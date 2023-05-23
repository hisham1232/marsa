<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        // $linkid = $helper->cleanString($_GET['linkid']);
        // $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['id']) && isset($_GET['linkid'])) {
                $id = $_GET['id'];
                $row = $helper->singleReadFullQry("SELECT i.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleaveovertimefiled as i LEFT OUTER JOIN staff as s ON s.staffId = i.createdBy WHERE i.id = $id");
                $requestNo = $row['requestNo'];
                $dateFiled = date('d/m/Y H:i:s',strtotime($row['dateFiled']));
                $ot_type = $row['ot_type'];
                $requester = $row['staffName'];
                $notes = $row['notes'];
                if($helper->totalCount < 1) {
                    header("Location: index.php");
                }
            } else {
                header("Location: index.php");
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0"> Overtime Request Approval</h3>
                                    <!---this is for HOS,HOC,HOD and higher position--->
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Overtime</li>
                                        <li class="breadcrumb-item">My Overtime Request List</li>
                                        <li class="breadcrumb-item">Overtime Request Approval</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card bg-light-yellow" style="border-color: #eee;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-8 col-xs-18">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Overtime Request Details</h3>
                                                                    <h6 class="card-subtitle"></h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <h3 class="text-muted text-success">Request No
                                                                                <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span>
                                                                            </h3>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <form action="#" class="form-horizontal">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Date Filed</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" value="<?php echo $dateFiled; ?>" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Type</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control" value="<?php echo $ot_type; ?>" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon2">
                                                                                                <i class="far fa-envelope"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Requester</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" readonly class="form-control" value="<?php echo $requester; ?>" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Notes</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <textarea class="form-control" rows="2" readonly><?php echo $notes; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h3><p class="badge badge-info"><em><i class="fa fa-users"></i> List of Staff to be given an Internal Leave Compensation for their Overtime</em></p></h3>
                                                                    <hr class="m-t-0 m-b-10">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Staff ID</th>
                                                                                    <th>Staff Name</th>
                                                                                    <th>Start</th>
                                                                                    <th>End</th>
                                                                                    <th>Total Days</th>
                                                                                    <th>Attendance Status</th>
                                                                                    <!-- <td>Confirmed <i class="fas fa-check-circle text-success"></i></td>
                                                                                    <td>Upcoming Days <i class="fas fa-calendar-alt text-warning"></i></td> -->
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $rows = $helper->readData("SELECT i.internalleaveovertime_id, i.staffId, i.startDate, i.endDate, i.total, i.status, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleaveovertimedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId WHERE i.internalleaveovertime_id = '$requestNo' ORDER BY staffName");
                                                                                    if($helper->totalCount != 0) {
                                                                                        $k = 0;
                                                                                        foreach($rows as $row) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?php echo ++$k.'.'; ?></td>
                                                                                                <td><?php echo $row['staffId']; ?></td>
                                                                                                <td><?php echo $row['staffName']; ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                                <td>
                                                                                                    <?php 
                                                                                                        if($row['status'] == 'Credited') {
                                                                                                            if($row['total'] <= 1) {
                                                                                                                echo "+".$row['total']." day leave added."; 
                                                                                                            } else {
                                                                                                                echo "+".$row['total']." days leave added."; 
                                                                                                            }
                                                                                                        } else {
                                                                                                            if($row['total'] <= 1) {
                                                                                                                echo "+".$row['total']." day leave pending."; 
                                                                                                            } else {
                                                                                                                echo "+".$row['total']." days leave pending."; 
                                                                                                            }
                                                                                                        }                                                                                                        
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                        if($row['status'] == 'Pending' || $row['status'] == 'Approved' || $row['status'] == 'Drafted') {
                                                                                                            echo 'Upcoming Days <i class="fas fa-calendar-alt text-warning"></i>';
                                                                                                        } else if($row['status'] == 'Credited') { //means that the internalleave balance was added already
                                                                                                            echo 'Confirmed <i class="fas fa-check-circle text-success"></i>';
                                                                                                        }    
                                                                                                    ?>
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
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Overtime Approval Form</h3>
                                                                    <h6 class="card-subtitle">إستمارة إعتماد الوقت الاضافي</h6>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                $i = 0;
                                                                $rows = $helper->readData("SELECT * FROM internalleaveovertime_history WHERE internalleaveovertime_id = $id");
                                                                if($helper->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                                        ?>
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-info ribbon-vertical-l"><?php echo ++$i; ?></div>
                                                                            <h4 class="ribbon-content"><em>Status:</em> <?php echo $row['status']; ?></h4>
                                                                            <span class="text-muted pull-right"><?php echo date('F d, Y H:i:s',strtotime($row['created'])); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $row['notes']; ?>.</i></p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
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
</html>