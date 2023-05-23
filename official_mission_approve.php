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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Notification - For Approvals</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Official Duty</li>
                                        <li class="breadcrumb-item">Approve Official Duty</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-success">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="profiletimeline">
                                                        <div class="sl-item">
                                                            <div class="sl-left"> 
                                                                <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$staffId.'.jpg'; ?>" class="img-circle" alt="Staff Image"><br>
                                                                <input type="hidden" class="approverStaffId" value="<?php echo $staffId; ?>" />
                                                                <input type="hidden" class="approverEmail" value="<?php echo $logged_in_email; ?>" />
                                                            </div>
                                                            <div class="sl-right">
                                                                <div><a href="javascript:;" class="link"><?php echo $logged_name; ?></a> <span class="sl-date">[Staff ID : <?php echo $staffId; ?>]</span>
                                                                    <div class="like-comm">
                                                                        <?php
                                                                            //Official Duty Counter
                                                                            $rowsSeq = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                                                                            if($helper->totalCount != 0) {
                                                                                $sequence_numbers = array();
                                                                                foreach($rowsSeq as $row){
                                                                                    array_push($sequence_numbers,$row['sequence_no']);
                                                                                }
                                                                                $myCurrentSequenceNo = implode(', ', $sequence_numbers);
                                                                            } else {
                                                                                $myCurrentSequenceNo = 0;
                                                                            }
                                                                            $countOM = $helper->singleReadFullQry("SELECT count(id) as OMCount FROM standardleave WHERE current_approver_id = $myPositionId AND currentStatus = 'Pending' AND leavetype_id = 13");
                                                                            $totalApprovals = $countOM['OMCount']; //Add the others here...
                                                                        ?>
                                                                        <a href="javascript:void(0)" class="link m-r-5">You have [<?php echo $totalApprovals; ?>] for Approvals waiting</a>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#stl" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Official Duty
                                                            <?php
                                                                if($totalApprovals > 0) {
                                                                ?>
                                                                    <span class="badge badge-pill badge-danger font-weight-bold"><?php echo $totalApprovals; ?></span>
                                                                <?php
                                                                } else {
                                                            ?>        
                                                                    <span class="badge badge-pill badge-danger font-weight-bold"></span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </span>
                                                    </a> 
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content tabcontent-border p-10">
                                                <div class="tab-pane active" id="stl" role="tabpanel">
                                                    <?php
                                                        $sql = "SELECT stl.*, d.name as department, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor, lt.name as leaveType FROM standardleave as stl 
                                                        LEFT OUTER JOIN employmentdetail as e ON e.staff_id = stl.staff_id
                                                        LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id
                                                        LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                        LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                        LEFT OUTER JOIN leavetype as lt ON lt.id = stl.leavetype_id
                                                        WHERE stl.current_approver_id = $myPositionId AND stl.currentStatus = 'Pending' AND leavetype_id = 13 AND e.isCurrent = 1
                                                        ORDER BY stl.id";
                                                        //echo $sql;
                                                        $rows = $helper->readData($sql);
                                                        if($helper->totalCount != 0) {
                                                            ?>            
                                                            <div class="card">
                                                                <div class="card-header bg-light-success2">
                                                                    <h3 class="card-title">Official Duty For Approvals List <span class="text-danger">[<?php echo $totalApprovals; ?> - application to approve]</span></h3>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <p class="m-0 p-0 text-primary">To Quick APPROVE or Decline Application:</p>
                                                                            <p class="m-0 p-0">1. Click the <span class="font-weight-bold">application</span> the list or click <span class="font-weight-bold">SELECT ALL</span> button</p>
                                                                            <p class="m-0 p-0">2. Click <span class="font-weight-bold">APPROVE</span> or <span class="font-weight-bold">DECLINE</span> button below</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                            <p class="m-0 p-0">1. Click the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">  
                                                                </div>    
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="standardLeaveTable" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>Request No</th>
                                                                                    <th>Staff ID/Name</th>
                                                                                    <th>Department</th>
                                                                                    <th>Sponsor</th>
                                                                                    <th>Leave Category</th>
                                                                                    <th>Leave Date</th>
                                                                                    <th>Days</th>
                                                                                    <th>Reason</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php    
                                                                                    if($helper->totalCount != 0) {
                                                                                        foreach($rows as $row){
                                                                                ?>
                                                                                            <tr>
                                                                                                <td><?php echo $row['id']; ?></td>
                                                                                                <td><?php echo $row['requestNo']; ?></td>
                                                                                                <td><?php echo $row['staff_id']." - ".$row['staffName']; ?></td>
                                                                                                <td><?php echo $row['department']; ?></td>
                                                                                                <td><?php echo $row['sponsor']; ?></td>
                                                                                                <td><?php echo $row['leaveType']; ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['startDate'])).' to '.date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                                <td><?php echo $row['total']; ?></td>
                                                                                                <td><?php echo $row['reason']; ?></td>
                                                                                                <td>
                                                                                                    <?php 
                                                                                                        if($row['attachment'] != '') {
                                                                                                            ?>
                                                                                                            <input type='hidden' class='id' value="<?php echo $row['id']; ?>" />
                                                                                                            <button class='btn btn-outline-danger btn-sm viewAttachment' data-toggle='modal' data-target='#modalAttachment'><i class="fas fa-file-pdf"></i> View Attachment</button>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                    <a href="javascript:;" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" class="btn btn btn-outline-info btn-sm viewStandardLeaveDetails" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-search"></i> View</a>

                                                                                                </td>
                                                                                            </tr>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <button type="button" class="btn btn-danger StLDeclineSelected"><i class="fas fa-thumbs-down"></i> DECLINE Selected Records</button>
                                                                        <button type="button" class="btn btn-primary StLApproveSelected"><i class="fas fa-thumbs-up"></i> APPROVE Selected Records</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>        
                                                            <!---if no need for approvals-->
                                                            <div class="card">
                                                                <div class="card-body bg-light-danger2">
                                                                    <div class="d-flex flex-wrap">
                                                                        <div style="margin:auto !important;">
                                                                            <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                                <center><i class="fas fa-clipboard-list"></i></center>
                                                                            </h1>
                                                                            <h2 class="text-danger">NO Records Waiting for APPROVAL Found!</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>        
                                                </div>
                                            </div>
                                            <!--end tabcontent-->

                                        </div><!--end card body-->
                                    </div><!--card border-success-->
                                </div><!--end col 12-->
                            </div><!--end row-->
                        </div>
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script src="assets/plugins/datatables/dataTables.select.min.js"></script>
                <script>
                    /*RETRIEVING DATA FROM THE SELECT ROWS FUNCTION-------------------------------------------------------------------- */
                    $(document).ready(function () {
                        function ajaxLoader(linkPage,variables,divName){
                            $(divName).empty().html("<i class='fa fa-info-circle text-warning'></i> <span class='text-warning'>Processing your action, please wait</span> <img src='scripts/ajax-loader.gif'/>");
                            $.get(linkPage + "?" + variables,function(data){$(divName).html(data);});
                        }
                        
                        var oTable = $('#standardLeaveTable').DataTable();
                        $('#standardLeaveTable tbody').on('click', 'tr', function () {
                            $(this).toggleClass('selected');
                            var pos = oTable.row(this).index();
                            var row = oTable.row(pos).data();
                            console.log(row);
                        });

                        $('.StLApproveSelected').click(function () {
                            var oData = oTable.rows('.selected').data();
                            var iDsSelected = [];
                            for (var i = 0; i < oData.length; i++) {
                                iDsSelected.push(oData[i][0]);
                            }
                            if(iDsSelected.length > 0) {
                                bootbox.confirm({
                                    closeButton: false,
                                    size: 'large',
                                    message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Confirm Action.</h4><br/><p class='processingRequest'>You are about to approve selected standard leave. Continue approval?</p>",
                                    buttons: {
                                        confirm: {
                                            label: '<i class="fas fa-check"></i> Yes',
                                            className: 'btn-primary btn-bootbox-yes'
                                        },
                                        cancel: {
                                            label: '<i class="fas fa-times"></i> No',
                                            className: 'btn-danger btn-bootbox-no'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result==true){
                                            var approverId = $('.approverStaffId').val();
                                            var approverEmail = $('.approverEmail').val();
                                            ajaxLoader("notification_for_approvals_actions.php","requestNoS="+iDsSelected+"&approverId="+approverId+"&approverEmail="+approverEmail+"&action=1&approvalType=om",".processingRequest");
                                            $('.btn-bootbox-yes').hide();
                                            $('.btn-bootbox-no').hide();
                                            return false;
                                        }
                                    }
                                });
                            }    
                        });

                        $('.StLDeclineSelected').click(function () {
                            var oData = oTable.rows('.selected').data();
                            var iDsSelected = [];
                            for (var i = 0; i < oData.length; i++) {
                                iDsSelected.push(oData[i][0]);
                            }
                            if(iDsSelected.length > 0) {
                                bootbox.confirm({
                                    closeButton: false,
                                    size: 'large',
                                    message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Confirm Action.</h4><br/><p class='processingRequest'>You are about to decline selected standard leave. Continue decline?</p>",
                                    buttons: {
                                        confirm: {
                                            label: '<i class="fas fa-check"></i> Yes',
                                            className: 'btn-primary btn-bootbox-yes'
                                        },
                                        cancel: {
                                            label: '<i class="fas fa-times"></i> No',
                                            className: 'btn-danger btn-bootbox-no'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result==true){
                                            var approverId = $('.approverStaffId').val();
                                            var approverEmail = $('.approverEmail').val();
                                            ajaxLoader("notification_for_approvals_actions.php","requestNoS="+iDsSelected+"&approverId="+approverId+"&approverEmail="+approverEmail+"&action=4&approvalType=om",".processingRequest");
                                            $('.btn-bootbox-yes').hide();
                                            $('.btn-bootbox-no').hide();
                                            return false;
                                        }
                                    }
                                });
                            }    
                        });

                        $('.viewStandardLeaveDetails').click(function(e){
                            var id = $(this).data('id');
                            var requestNo = $(this).data('requestno');
                            var data = {
                                id : id,
                                requestNo : requestNo
                            }
                            $.ajax({
                                url	 : 'ajaxpages/leaves/standardleave/standardleave_history_approval.php'
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
                                            title: "<p class='text-primary STLApprovedConfirmation'><i class='fas fa-info-circle'></i> Standard Leave Approval</p>",
                                            buttons: {
                                                decline: {
                                                    label: '<i class="fas fa-thumbs-down"></i> Decline',
                                                    className: 'btn-danger btn-bootbox-decline',
                                                    callback: function(result){
                                                        var id = e.id;
                                                        var position_id = e.position_id;
                                                        var requestNo = e.requestNo;
                                                        var no_of_days = e.no_of_days;
                                                        var approverId = $('.approverStaffId').val();
                                                        var approverEmail = $('.approverEmail').val();
                                                        var notes = $('.notesComments').val();
                                                        if(notes == '') {
                                                            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your notes or comments must not be blank.");
                                                            return false;
                                                        } else {
                                                            ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNoS="+requestNo+"&approverId="+approverId+"&approverEmail="+approverEmail+"&notes="+notes+"&position_id="+position_id+"&no_of_days="+no_of_days+"&action=3&approvalType=om",".STLApprovedConfirmation");
                                                            $('.btn-bootbox-approve').hide();
                                                            $('.btn-bootbox-decline').hide();
                                                            $('.btn-bootbox-close').hide();
                                                            return false;
                                                        }    
                                                    }
                                                },
                                                ok: {
                                                    label: '<i class="fas fa-thumbs-up"></i> Approve',
                                                    className: 'btn-primary btn-bootbox-approve',
                                                    callback: function (result) {
                                                        var id = e.id;
                                                        var position_id = e.position_id;
                                                        var requestNo = e.requestNo;
                                                        var no_of_days = e.no_of_days;
                                                        var approverId = $('.approverStaffId').val();
                                                        var approverEmail = $('.approverEmail').val();
                                                        var notes = $('.notesComments').val();
                                                        if(notes == '') {
                                                            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your notes or comments must not be blank.");
                                                            return false;
                                                        } else {
                                                            ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNoS="+requestNo+"&approverId="+approverId+"&approverEmail="+approverEmail+"&notes="+notes+"&position_id="+position_id+"&no_of_days="+no_of_days+"&action=2&approvalType=om",".STLApprovedConfirmation");
                                                            $('.btn-bootbox-approve').hide();
                                                            $('.btn-bootbox-decline').hide();
                                                            $('.btn-bootbox-close').hide();
                                                            return false;
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

                        $('.viewAttachment').click(function(e){
                            var id  = $(this).parent().find('.id').val();
                            var data = {
                                id  : id
                            }
                            $.ajax({
                                url  : 'ajaxpages/leaves/standardleave/getattachment.php',
                                type    : 'POST',
                                dataType: 'json',
                                data    : data,
                                success : function(e){
                                    if(e.error == 0) {
                                        $('#myiframe').attr('src', e.url)
                                    }
                                }, error  : function(e){}
                            });
                            
                        });
                    });
                    /*-------------------------------------------------------------------------------------------------------------------*/
                </script>
                <script type="text/javascript">
                    $('#standardLeaveTable').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }
                    });
                </script>
                <div class="modal fade" id="modalAttachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header bg-light-danger2">
                        <h4 class="modal-title" id="exampleModalLabel1"><i class="fas fa-file-pdf"></i> Leave Attachment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                        <div class="modal-body">
                        <div style="text-align: center;">
                            <iframe id="myiframe" src="" style="width:100%; height:700px" frameborder="0"></iframe>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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