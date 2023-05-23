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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Approve Short Leave Request</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Short Leave</li>
                                        <li class="breadcrumb-item active">My Approvals Short Leave Request List</li>
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
                                            <h4 class="card-title">MY SHORT LEAVE REQUEST APPROVALS (<span class="text-primary">All Short Leave Request that was ALREADY APPROVED/DECLINED BY ME</span>)</h4>
                                            <h6>قائمة طلبات الإجازة القصيرة التي قمت  بإعتمادها</h6>                        
                                        </div><!--end header-->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="shortLeaveList" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Staff ID - Name</th>
                                                            <th>Department</th>
                                                            <!-- <th>Section</th> -->
                                                            <th>Sponsor</th>
                                                            <!-- <th>Requested Date</th> -->
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
                                                                $SQL = "SELECT h.id, h.shortleave_id, h.requestNo, sh.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sp.name as sponsor, h.status, sh.leaveDate, sh.startTime, sh.endTime, sh.total, h.modified
                                                                FROM shortleave_history as h
                                                                LEFT OUTER JOIN shortleave as sh ON sh.id = h.shortleave_id
                                                                LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id
                                                                LEFT OUTER JOIN employmentdetail as e ON e.staff_id = sh.staff_id
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                                WHERE h.staff_id = $staffId AND sh.leaveDate >= '$startDate' AND sh.leaveDate <= '$endDate' AND e.status_id = 1 AND e.isCurrent = 1
                                                                ORDER BY h.shortleave_id DESC";
                                                            } else {
                                                                $SQL = "SELECT h.id, h.shortleave_id, h.requestNo, sh.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sp.name as sponsor, h.status, sh.leaveDate, sh.startTime, sh.endTime, sh.total, h.modified
                                                                FROM shortleave_history as h
                                                                LEFT OUTER JOIN shortleave as sh ON sh.id = h.shortleave_id
                                                                LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id
                                                                LEFT OUTER JOIN employmentdetail as e ON e.staff_id = sh.staff_id
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                                WHERE h.staff_id = $staffId AND e.status_id = 1 AND e.isCurrent = 1
                                                                ORDER BY h.shortleave_id DESC";
                                                            }
                                                            //echo $SQL;
                                                            $rows = $helper->readData($SQL);
                                                            if($helper->totalCount != 0) {
                                                                foreach($rows as $row){
                                                                    ?>
                                                                    <tr id="<?php echo $row['id']; ?>">
                                                                        <td><a class="text-success history" style="cursor:pointer" data-id="<?php echo $row['shortleave_id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>"><?php echo $row['requestNo']; ?></a></td>
                                                                        <td><?php echo $row['staff_id']." - ".$row['staffName']; ?></td>
                                                                        <td><?php echo $row['department']; ?></td>
                                                                        <td><?php echo $row['sponsor']; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['leaveDate'])); ?></td>
                                                                        <td><?php echo $row['startTime']; ?></td>
                                                                        <td><?php echo $row['endTime']; ?></td>
                                                                        <td><?php echo $row['total']; ?></td>
                                                                        <td><?php echo date('d/m/Y H:i:s',strtotime($row['modified'])); ?></td>
                                                                        <td><?php echo $row['status']; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }    
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                        </div><!--end card body list-->
                                    </div><!--end card for list-->
                                </div>
                            </div><!--end row for whole-->        
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
                <script>
                    $(document).ready(function() {
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
                                        bootbox.alert({
                                            title: "<span class='text-primary'><i class='fa fa-info-circle'></i> Short Leave Information</span>", 
                                            message: e.message,
                                            size: 'large'
                                        });
                                    }	
                                }
                                ,error	: function(e){
                                }
                            });
                        });
                    });    
                </script>
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
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>