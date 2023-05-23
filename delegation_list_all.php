<?php    
    include('include_headers.php');                                 
?>
<body class="fix-header fix-sidebar card-no-border">
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
                        <h3 class="text-themecolor m-b-0 m-t-0">All Delegation List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Delegation</li>
                            <li class="breadcrumb-item">All Delegation List</li>

                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!---start for list div-->
                        <div class="card">
                            <div class="card-header bg-light-info p-t-5 p-b-0">
                                <h4 class="card-title">List of All Delegation</h4>
                                <h6 class="card-subtitle">قائمة كل التفويضات</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example23" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Request ID</th>
                                                <th>Request By</th>
                                                <th>Delegated Staff</th>
                                                <th>Department</th>
                                                <th>Role Delegated</th>
                                                <th>Delegation Date</th>
                                                <th>Days</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" class="created_by" value="<?php echo $logged_name; ?>" />
                                            <?php 
                                                $rows = $helper->readData("SELECT d.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffNameFrom, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as staffNameTo, dd.name as department FROM delegation d INNER JOIN staff as s ON d.staffIdFrom = s.staffId INNER JOIN staff as ss ON d.staffIdTo = ss.staffId INNER JOIN employmentdetail as e ON d.staffIdFrom = e.staff_id INNER JOIN department as dd ON dd.id = e.department_id AND e.isCurrent = 1");
                                                if($helper->totalCount != 0) {
                                                    $roles = '';
                                                    foreach ($rows as $row) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row['requestNo']; ?></td>
                                                            <td><?php echo $row['staffNameFrom']; ?></td>
                                                            <td><?php echo $row['staffNameTo']; ?></td>
                                                            <td><?php echo $row['department']; ?></td>
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
                                                            <td><?php echo date('d/m/Y',strtotime($row['startDate'])).' to '.date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                            <td>
                                                                <?php 
                                                                    $datetime1 = strtotime($row['startDate']);
                                                                    $datetime2 = strtotime($row['endDate']);
                                                                    $interval = $datetime2 - $datetime1;
                                                                    echo round($interval / (60 * 60 * 24)) + 1;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['status']; ?></td>
                                                            <td>
                                                                <button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm viewDelegation" data-toggle="modal" data-target="#viewModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['staffNameTo']; ?>" data-delegated_staffby="<?php echo $row['staffNameFrom']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-search fa-2x"></i></button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="card">
                                                        <div class="card-body bg-light-info">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records</h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end table-responsive-->
                            </div>
                            <!--end card body-->
                        </div>
                        <!--end card-->
                        <!---no record --->
                        
                    </div>
                    <!--end col-lg-12-->
                </div>
                <!--end row-->
            </div>

            <!--- Start Modal for view-->
            <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Delegation Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-7">Requested By: <span class="text-primary vRequestedBy"></span></div>
                                    <div class="col-md-5">Request No: <span class="text-primary vRequestNo"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">Requested Date: <span class="text-primary vDateFiled"></span></div>
                                    <div class="col-md-5">Status: <span class="text-primary vStatus"></span></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-3">Delegated Role:</div><div class="col-md-7"><span class="text-primary vRolesUseDotHTML"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Delegated Staff: </div><div class="col-md-7"><span class="text-primary vDelegatedStaff"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Duration: </div><div class="col-md-7"><span class="text-primary vDuration"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Delegation Note: </div><div class="col-md-7"><span class="text-primary vNote"></span></div>
                                </div>
                                <hr />
                                <p class="font-weight-bold">History</p>
                                <div class="table">
                                    <table id="vHistory" class="table table-bordered table-striped table-sm have-border">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Staff Name</th>
                                                <th>Date</th>
                                                <th>Notes/Comment</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.end modal for view details -->
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
    <script>
        // MAterial Date picker    
        $('#mdate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'DD/MM/YYYY'
        });
        $('#start_date').datepicker({
            weekStart: 0,
            time: false,
            format: 'dd/mm/yyyy'
        });
        $('#end_date').datepicker({
            weekStart: 0,
            time: false,
            format: 'dd/mm/yyyy'
        });
        jQuery('#date-range').datepicker({
            toggleActive: true
        });
        $('.daterange').daterangepicker();
    </script>
    <script>
        $(function () { 
            $('.viewDelegation').click(function(e){
                var id = $(this).data('id');
                $('.vRequestNo').text($(this).data('requestno'));
                $('.vRequestedBy').text($(this).data('delegated_staffby'));
                $('.vStatus').text($(this).data('status'));
                $('.vDateFiled').text($(this).data('datefiled')); 
                $('.vDelegatedStaff').text($(this).data('delegated_staff')); 
                $('.vDuration').text($(this).data('duration'));
                $('.vNote').text($(this).data('note'));
                var ctr = 1;
                var data = {
                    id : id
                }
                $.ajax({
                    url  : 'ajaxpages/delegations/modals/history.php'
                    ,type    : 'POST'
                    ,dataType: 'json'
                    ,data    : data
                    ,success : function(e){
                        $('#vHistory tbody').empty();
                        $.each(e.rows, function(i, j){
                            $('#vHistory tbody').append("<tr><td>"+ctr+". </td><td>" + j.staffName + "</td><td>" + j.created + "</td><td>" + j.notes + "</td><td>" + j.status + "</td></tr>");
                            ctr++;
                        });
                    }
                    ,error  : function(e){}
                });
                $.ajax({
                    url  : 'ajaxpages/delegations/modals/list_roles.php'
                    ,type    : 'POST'
                    ,dataType: 'json'
                    ,data    : data
                    ,success : function(e){
                        $('.vRolesUseDotHTML').html(e.rows);
                    }
                    ,error  : function(e){}
                });                            
            });

            $('.stopDelegation').click(function(e){
                var id = $(this).data('id');
                $('.delegationId').val($(this).data('id'));
                $('.delegationStopRequestNo').val($(this).data('requestno'));
                $('.stRequestNo').text($(this).data('requestno'));
                $('.stRequestedBy').text($('.created_by').val());
                $('.stStatus').text($(this).data('status'));
                $('.stDateFiled').text($(this).data('datefiled')); 
                $('.stDelegatedStaff').text($(this).data('delegated_staff')); 
                $('.stDuration').text($(this).data('duration'));
                $('.stNote').text($(this).data('note'));
                var data = {
                    id : id
                }
                $.ajax({
                    url  : 'ajaxpages/delegations/modals/history.php'
                    ,type    : 'POST'
                    ,dataType: 'json'
                    ,data    : data
                    ,success : function(e){
                        $('#stHistory tbody').empty();
                        $.each(e.rows, function(i, j){
                            $('#stHistory tbody').append("<tr><td>" + j.staffName + "</td><td>" + j.created + "</td><td>" + j.notes + "</td><td>" + j.status + "</td></tr>");
                        });
                    }
                    ,error  : function(e){}
                });
                $.ajax({
                    url  : 'ajaxpages/delegations/modals/list_roles.php'
                    ,type    : 'POST'
                    ,dataType: 'json'
                    ,data    : data
                    ,success : function(e){
                        $('.stRolesUseDotHTML').html(e.rows);
                    }
                    ,error  : function(e){}
                });
                /** --------------------------------------------------------------------------------------- **/
            });

            $('.extendDelegation').click(function(e){
                var id = $(this).data('id');
                $('.delegationExtId').val($(this).data('id'));
                $('.delegationExtendRequestNo').val($(this).data('requestno'));
                $('.exRequestNo').text($(this).data('requestno'));
                $('.exRequestedBy').text($('.created_by').val());
                $('.exStatus').text($(this).data('status'));
                $('.exDateFiled').text($(this).data('datefiled')); 
                $('.exDelegatedStaff').text($(this).data('delegated_staff')); 
                $('.exDuration').text($(this).data('duration'));
                $('.exNote').text($(this).data('note'));
                var data = {
                    id : id
                }
                $.ajax({
                    url  : 'ajaxpages/delegations/modals/history.php'
                    ,type    : 'POST'
                    ,dataType: 'json'
                    ,data    : data
                    ,success : function(e){
                        $('#exHistory tbody').empty();
                        $.each(e.rows, function(i, j){
                            $('#exHistory tbody').append("<tr><td>" + j.staffName + "</td><td>" + j.created + "</td><td>" + j.notes + "</td><td>" + j.status + "</td></tr>");
                        });
                    }
                    ,error  : function(e){}
                });
                $.ajax({
                    url  : 'ajaxpages/delegations/modals/list_roles.php'
                    ,type    : 'POST'
                    ,dataType: 'json'
                    ,data    : data
                    ,success : function(e){
                        $('.exRolesUseDotHTML').html(e.rows);
                    }
                    ,error  : function(e){}
                });
                /** --------------------------------------------------------------------------------------- **/
            });
        });
    </script>    
</body>
</html>