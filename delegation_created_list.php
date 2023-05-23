<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
?>

            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Created Delegation</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Delegation</li>
                                        <li class="breadcrumb-item">My Created Delegation List</li>

                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <?php 
                                    if(isset($_POST['stopDelegationBtn'])) {
                                        $notes = $_POST['stopDelegationNotes'];
                                        $id = $_POST['delegationId'];
                                        $requestNo = $_POST['delReqId'];
                                        $stopDel = new DbaseManipulation;
                                        $fieldsHistory = [
                                            'delegation_id'=>$id,
                                            'requestNo'=>$requestNo,
                                            'staff_id'=>$staffId,
                                            'status'=>'Delegation has been stopped and the role is now inactive',
                                            'notes'=>$notes,
                                            'ipAddress'=>$stopDel->getUserIP()
                                        ];
                                        if($stopDel->insert("delegation_history",$fieldsHistory)) {
                                            $stopDel->executeSQL("UPDATE delegation SET status = 'Stopped' WHERE id = $id");
                                            //Edit and Update the following table if it is assigned to him:
                                            /*
                                                1. approvalsequence_shortleave
                                                2. approvalsequence_standardleave
                                                3. approvalsequence_standardleave_5
                                            */
                                            //Email here both the stopper and the issuer
                                            ?>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#myModal').modal('show');
                                                    });
                                                </script>
                                            <?php
                                        }
                                    }

                                    if(isset($_POST['extendDelegationBtn'])) {
                                        $notes = $_POST['extendNotes'];
                                        $id = $_POST['delegationId'];
                                        $requestNo = $_POST['delReqId'];
                                        $extend = new DbaseManipulation;
                                        $fieldsHistory = [
                                            'delegation_id'=>$id,
                                            'requestNo'=>$requestNo,
                                            'staff_id'=>$staffId,
                                            'status'=>'Delegation has been extended',
                                            'notes'=>$notes,
                                            'ipAddress'=>$extend->getUserIP()
                                        ];
                                        if($extend->insert("delegation_history",$fieldsHistory)) {
                                            $startDate = $_POST['startDate'];
                                            $endDate = $_POST['endDate'];
                                            $extend->executeSQL("UPDATE delegation SET status = 'Active', startDate = '$startDate', endDate = '$endDate' WHERE id = $id");
                                            //Email here both the extender and the issuer
                                            ?>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#myModal2').modal('show');
                                                    });
                                                </script>
                                            <?php
                                        }
                                    }
                                ?>
                                <div class="col-lg-12">
                                    <?php
                                        $rows = $helper->readData("SELECT d.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as delegated_staff FROM delegation as d LEFT OUTER JOIN staff as s ON s.staffId = d.staffIdTo WHERE d.staffIdFrom = '$staffId'");
                                        if($helper->totalCount != 0) {
                                            ?>
                                            <div class="card">
                                                <div class="card-header bg-light-info p-t-5 p-b-0">
                                                    <h4 class="card-title">List of Delegation Created by [<?php echo $logged_name; ?>] </h4>
                                                    <input type="hidden" class="created_by" value="<?php echo $logged_name; ?>" />
                                                    <h6 class="card-subtitle">قائمة التفويض</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="dynamicTable" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Request ID</th>
                                                                    <th>Delegated Staff</th>
                                                                    <th>Delegated Role</th>
                                                                    <th>Duration</th>
                                                                    <th>Days</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $ctr = 0;
                                                                    foreach($rows as $row){
                                                                        $roles = "";
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo ++$ctr.'.'; ?></td>
                                                                                <td class="text-primary"><?php echo $row['requestNo']; ?></td>
                                                                                <td><?php echo $row['delegated_staff']; ?></td>
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
                                                                                <td>From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $datetime1 = strtotime($row['startDate']);
                                                                                        $datetime2 = strtotime($row['endDate']);
                                                                                        $interval = $datetime2 - $datetime1;
                                                                                        echo round($interval / (60 * 60 * 24)) + 1;
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php if($row['status'] == 'Active') echo 'Accepted/'.$row['status']; else echo $row['status']; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                        if($row['status'] == 'Pending') {
                                                                                    ?>        
                                                                                            <button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm viewDelegation" data-toggle="modal" data-target="#viewModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-search fa-2x"></i></button>

                                                                                            <button type="button" title="Click to Stop Delegation" class="btn btn btn-outline-danger btn-sm stopDelegation" data-toggle="modal" data-target="#stopModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-times-circle fa-2x"></i></button>
                                                                                            
                                                                                    <?php
                                                                                        } else if($row['status'] == 'Active') {
                                                                                    ?>    
                                                                                            <button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm viewDelegation" data-toggle="modal" data-target="#viewModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-search fa-2x"></i></button>

                                                                                            <button type="button" title="Click to Stop Delegation" class="btn btn btn-outline-danger btn-sm stopDelegation" data-toggle="modal" data-target="#stopModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-times-circle fa-2x"></i></button>

                                                                                            <button type="button" title="Click to Extend Delegation" class="btn btn btn-outline-primary btn-sm extendDelegation" data-toggle="modal" data-target="#extendModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-edit fa-2x"></i></button>
                                                                                    <?php
                                                                                        } else if($row['status'] == 'Finished') {
                                                                                    ?>
                                                                                            <button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm viewDelegation" data-toggle="modal" data-target="#viewModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-search fa-2x"></i></button>
                                                                                            
                                                                                            <button type="button" title="Click to Extend Delegation" class="btn btn btn-outline-primary btn-sm extendDelegation" data-toggle="modal" data-target="#extendModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-edit fa-2x"></i></button>
                                                                                    <?php    
                                                                                        } else if($row['status'] == 'Stopped') {
                                                                                    ?>
                                                                                            <button type="button" title="Click to View Details" class="btn btn btn-outline-info btn-sm viewDelegation" data-toggle="modal" data-target="#viewModal" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-delegated_staff="<?php echo $row['delegated_staff']; ?>" data-status="<?php echo $row['status']; ?>" data-datefiled="<?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?>" data-duration="From <?php echo date('d/m/Y',strtotime($row['startDate'])); ?> To <?php echo date('d/m/Y',strtotime($row['endDate'])); ?>" data-note="<?php echo $row['reason']; ?>"><i class="fas fa-search fa-2x"></i></button>
                                                                                    <?php    
                                                                                        }
                                                                                    ?>
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
                                                <div class="card-body bg-light-info">
                                                    <div class="d-flex flex-wrap">
                                                        <div style="margin:auto !important;">
                                                            <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                <center><i class="fas fa-clipboard-list"></i></center>
                                                            </h1>
                                                            <h2 class="text-danger">No Delegation List Found!</h2>
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
                        <!--- Start Modal for stop-->
                        <div class="modal fade" id="stopModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Stop Delegation</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-7">Requested By: <span class="text-primary stRequestedBy"></span></div>
                                                <div class="col-md-5">Request No: <span class="text-primary stRequestNo"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">Requested Date: <span class="text-primary stDateFiled"></span></div>
                                                <div class="col-md-5">Status: <span class="text-primary stStatus"></span></div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-3">Delegated Role:</div><div class="col-md-7"><span class="text-primary stRolesUseDotHTML"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Delegated Staff: </div><div class="col-md-7"><span class="text-primary stDelegatedStaff"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Duration: </div><div class="col-md-7"><span class="text-primary stDuration"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Delegation Note: </div><div class="col-md-7"><span class="text-primary stNote"></span></div>
                                            </div>
                                            <hr />
                                            <p class="font-weight-bold">History</p>
                                            <div class="table">
                                                <table id="stHistory" class="table table-bordered table-striped table-sm have-border">
                                                    <thead>
                                                        <tr>
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
                                            <hr>
                                            <p class="font-weight-bold">Extension Form </p>
                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Note</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="delegationId" class="form-control delegationId" />
                                                                <input type="hidden" name="delReqId" class="form-control delegationStopRequestNo" />
                                                                <textarea class="form-control notes" name="stopDelegationNotes" id="notes" required rows="2" required data-validation-required-message="Notes is required" minlength="10"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="far fa-comment"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <button type="submit" name="stopDelegationBtn" class="btn btn-danger waves-effect waves-light"><i class="fa fa-times"></i> Stop Delegation</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>    
                                        </div>
                                        <!--end container-fluid-->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.end modal for stop -->
                        <!----------------------------------------------------------------->
                        <!--- Start Modal for extend-->
                        <div class="modal fade" id="extendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-light-danger2">
                                        <h4 class="modal-title" id="exampleModalLabel1"><i class="fas fa-edit"></i> Extend Delegation</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-7">Requested By: <span class="text-primary exRequestedBy"></span></div>
                                                <div class="col-md-5">Request No: <span class="text-primary exRequestNo"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">Requested Date: <span class="text-primary exDateFiled"></span></div>
                                                <div class="col-md-5">Status: <span class="text-primary exStatus"></span></div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-3">Delegated Role:</div><div class="col-md-7"><span class="text-primary exRolesUseDotHTML"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Delegated Staff: </div><div class="col-md-7"><span class="text-primary exDelegatedStaff"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Duration: </div><div class="col-md-7"><span class="text-primary exDuration"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Delegation Note: </div><div class="col-md-7"><span class="text-primary exNote"></span></div>
                                            </div>
                                            <hr />
                                            <p class="font-weight-bold">History</p>
                                            <div class="table">
                                                <table id="exHistory" class="table table-bordered table-striped table-sm have-border">
                                                    <thead>
                                                        <tr>
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
                                            <hr>
                                            <p class="font-weight-bold">Extension Form </p>
                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span> New Date</label>
                                                    <div class="col-sm-9">
                                                        <div class='input-group mb-3'>
                                                            <input type='text' class="form-control addDateRange" />
                                                            <input type="hidden" name="startDate" value="<?php echo date('Y-m-d'); ?>" class="form-control startDate" />
                                                            <input type="hidden" name="endDate" value="<?php echo date('Y-m-d'); ?>" class="form-control endDate" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="far fa-calendar-alt"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Note</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="delegationId" class="form-control delegationExtId" />
                                                                <input type="hidden" name="delReqId" class="form-control delegationExtendRequestNo" />
                                                                <textarea class="form-control notes" name="extendNotes" id="notes" required rows="2" required data-validation-required-message="Notes is required" minlength="10"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="far fa-comment"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <button type="submit" name="extendDelegationBtn" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Extension</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>    
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body" style="text-align: center">
                                        <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                        <h5>Delegation has been stopped successfully!</h5>
                                        <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body" style="text-align: center">
                                        <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                        <h5>Delegation has been extended successfully!</h5>
                                        <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.end modal for extend -->
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>
                    $(function () {
                        $('.viewDelegation').click(function(e){
                            var id = $(this).data('id');
                            $('.vRequestNo').text($(this).data('requestno'));
                            $('.vRequestedBy').text($('.created_by').val());
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
                                url	 : 'ajaxpages/delegations/modals/history.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    $('#vHistory tbody').empty();
                                    $.each(e.rows, function(i, j){
                                        $('#vHistory tbody').append("<tr><td>"+ctr+". </td><td>" + j.staffName + "</td><td>" + j.created + "</td><td>" + j.notes + "</td><td>" + j.status + "</td></tr>");
                                        ctr++;
                                    });
                                }
                                ,error	: function(e){}
                            });
                            $.ajax({
                                url	 : 'ajaxpages/delegations/modals/list_roles.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    $('.vRolesUseDotHTML').html(e.rows);
                                }
                                ,error	: function(e){}
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
                                url	 : 'ajaxpages/delegations/modals/history.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    $('#stHistory tbody').empty();
                                    $.each(e.rows, function(i, j){
                                        $('#stHistory tbody').append("<tr><td>" + j.staffName + "</td><td>" + j.created + "</td><td>" + j.notes + "</td><td>" + j.status + "</td></tr>");
                                    });
                                }
                                ,error	: function(e){}
                            });
                            $.ajax({
                                url	 : 'ajaxpages/delegations/modals/list_roles.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    $('.stRolesUseDotHTML').html(e.rows);
                                }
                                ,error	: function(e){}
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
                                url	 : 'ajaxpages/delegations/modals/history.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    $('#exHistory tbody').empty();
                                    $.each(e.rows, function(i, j){
                                        $('#exHistory tbody').append("<tr><td>" + j.staffName + "</td><td>" + j.created + "</td><td>" + j.notes + "</td><td>" + j.status + "</td></tr>");
                                    });
                                }
                                ,error	: function(e){}
                            });
                            $.ajax({
                                url	 : 'ajaxpages/delegations/modals/list_roles.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    $('.exRolesUseDotHTML').html(e.rows);
                                }
                                ,error	: function(e){}
                            });
                            /** --------------------------------------------------------------------------------------- **/
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