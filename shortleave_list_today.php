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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Staff Short Leave For Today</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Short Leave</li>
                                        <li class="breadcrumb-item active">Search Staff Short Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <h4 class="card-title">All Short Leave List For Today</h4>
                                            <h6>قائمة كل الإجازات القصيرة</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="shortLeaveList" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Staff ID</th>
                                                            <th>Name</th>
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
                                                                $SQL = "SELECT sh.*, d.name as department, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor FROM shortleave as sh 
                                                                LEFT OUTER JOIN employmentdetail as e ON e.staff_id = sh.staff_id
                                                                LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                                WHERE sh.leaveDate >= '$startDate' AND sh.leaveDate <= '$endDate' AND e.isCurrent = 1 ORDER BY sh.id DESC";
                                                            } else {
                                                                $nowDateSL = date('Y-m-d');
                                                                $SQL = "SELECT sh.*, d.name as department, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor FROM shortleave as sh 
                                                                LEFT OUTER JOIN employmentdetail as e ON e.staff_id = sh.staff_id
                                                                LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                                WHERE e.isCurrent = 1 AND sh.dateFile = '$nowDateSL'
                                                                ORDER BY sh.id DESC";
                                                            }
                                                            //echo $SQL;
                                                            $rows = $helper->readData($SQL);
                                                            if($helper->totalCount != 0) {
                                                                foreach($rows as $row){
                                                                    ?>
                                                                    <tr id="<?php echo $row['id']; ?>">
                                                                        <td><a class="text-success history" style="cursor:pointer" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>"><?php echo $row['requestNo']; ?></a></td>
                                                                        <td><?php echo $row['staff_id']; ?></td>
                                                                        <td><?php echo $row['staffName']; ?></td>
                                                                        <td><?php echo $row['department']; ?></td>
                                                                        <td><?php echo $row['sponsor']; ?></td>
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
                            </div>
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
                                            title: "<span class='text-primary'><i class='fa fa-info-circle'></i> Information</span>", 
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
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>