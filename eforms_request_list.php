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
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Pending E-Forms Request</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">E-Forms</li>
                                        <li class="breadcrumb-item active">E-Forms Request List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <form action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Request Date</label>
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
                                        <small>Select starting and ending date in the date range picker and then click on Search Button.<br/>Click on toggle button to change the status from Pending to Resolved and vice-versa.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>
                                        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <h4 class="card-title">All Pending E-Forms Request
                                            <h6>كل طلبات الاستمارات الإلكتروني المعلقة</h6>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" class="updatedby" value="<?php echo $logged_name; ?>" />
                                            <div class="">
                                                <a class="btn btn-sm btn-info" href="eforms_request_list.php?linkid=<?php echo $linkid; ?>">Pending</a> | <a class="btn btn-sm btn-dark" href="eforms_request_list2.php?linkid=<?php echo $linkid; ?>"">Approved</a>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="shortLeaveList" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Date</th>
                                                            <th>Form</th>
                                                            <th>Staff ID</th>
                                                            <th>Staff Name</th>
                                                            <th>Status</th>
                                                            <th>Reason</th>
                                                            <th>Updated By</th>
                                                            <th>Updated Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['searchByDate'])) {
                                                                $startDate = $_POST['startDate'];
                                                                $endDate = $_POST['endDate'];
                                                                $SQL = "SELECT e.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, ef.name FROM e_forms_request as e LEFT OUTER JOIN staff as s ON e.requestBy = s.staffId LEFT OUTER JOIN e_forms as ef ON ef.id = e.eFormId FROM e_forms_request WHERE e.created >= '$startDate' AND e.created <= '$endDate' AND e.status = 'Pending' ORDER BY e.id DESC";
                                                            } else {
                                                                $SQL = "SELECT e.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, ef.name FROM e_forms_request as e LEFT OUTER JOIN staff as s ON e.requestBy = s.staffId LEFT OUTER JOIN e_forms as ef ON ef.id = e.eFormId WHERE e.status = 'Pending' ORDER BY e.id DESC";
                                                            }
                                                            //echo $SQL;
                                                            $rows = $helper->readData($SQL);
                                                            if($helper->totalCount != 0) {
                                                                foreach($rows as $row){
                                                                    ?>
                                                                    <tr id="<?php echo $row['id']; ?>">
                                                                        <td><span class="text-success history"><?php echo $row['requestNo']; ?></span></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['created'])); ?></td>
                                                                        <td><?php echo $row['name']; ?></td>
                                                                        <td><?php echo $row['requestBy']; ?></td>
                                                                        <td><?php echo $row['staffName']; ?></td>
                                                                        <td>
                                                                            <span class="istatus<?php echo $row['id']; ?>"><?php echo $row['status']; ?></span> 
                                                                            <button class="btn btn-sm btn-info edit" data-id="<?php echo $row['id']; ?>"><i class="fa fa-toggle-on"></i> Toggle Status</button>
                                                                        </td>
                                                                        <td><?php echo $row['reason']; ?></td>
                                                                        <td><span class="updatedBy<?php echo $row['id']; ?>"><?php echo $row['updatedBy']; ?></span></td>
                                                                        <td><?php echo date('d/m/Y H:i:s',strtotime($row['modified'])); ?></td>
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
                <?php include('include_scripts.php'); ?>
                <script>
                    $(function() {
                        $('.daterange').daterangepicker({
                            opens: 'left'
                        }, function(start, end, label) {
                            $(".startDate").val(start.format('YYYY-MM-DD'));
                            $('.endDate').val(end.format('YYYY-MM-DD'));
                            //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        });
                    });                            
                    $('.daterange').keypress(function(e) {
                        e.preventDefault();
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        $('.edit').click(function(e){
                            var id = $(this).data('id');
                            var updatedBy = $('.updatedby').val();
                            var data = {
                                id : id,
                                updatedby : updatedBy
                            }
                            $.ajax({
                                url	 : 'ajaxpages/eforms/toggle.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    if(e.error == 1){
                                    } else {
                                        $('.istatus'+id).text(e.sts);
                                        $('.updatedBy'+id).text(updatedBy);
                                    }	
                                },error	: function(e){
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