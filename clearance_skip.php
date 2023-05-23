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
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Skip Clearance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance</li>
                                        <li class="breadcrumb-item">Skip Clearance</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Add New </h3>
                                                    <h6 class="card-subtitle">This Skip Clearance Form is use whene any staff leave the college without clearance application</h6> 
                                                </div>
                                            </div>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $fields = [
                                                        'requestNo'=>$_POST['requestNo'],
                                                        'staffId'=>$_POST['staff_id'],
                                                        'leaveDate'=>$helper->mySQLDate($_POST['leaveDate']),
                                                        'enteredBy'=>$staffId,
                                                        'dateEntered'=>date('Y-m-d H:i:s',time())
                                                    ];
                                                    //Update Status Here...
                                                    $sql = "UPDATE employmentdetail SET isCurrent = 0 WHERE staff_id = ".$_POST['staff_id'];
                                                    $sql2 = "UPDATE employmentdetail SET status_id = ".$_POST['status_id']." WHERE staff_id = ".$_POST['staff_id'];
                                                    $updateEmp = new DbaseManipulation;
                                                    $updateEmp->executeSQL($sql);
                                                    $updateEmp->executeSQL($sql2);
                                                    //echo $sql.'<br><br>'.$sql2;
                                                    //exit;
                                                    $submit = new DbaseManipulation;
                                                    if($submit->insert("clearance_skip",$fields)){
                                                        ?>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#myModal').modal('show');
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Staff Name</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="staff_id" class="custom-select select2" required data-validation-required-message="Please select Staff">
                                                                    <option value="">Select Staff</option>
                                                                        <?php 
                                                                            $managers = new DbaseManipulation;
                                                                            $rows = $managers->readData($SQLActiveStaff);
                                                                            foreach ($rows as $row) {
                                                                        ?>
                                                                                <option value="<?php echo $row['staffId']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                        <?php            
                                                                            }    
                                                                        ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Status</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="status_id" class="custom-select select2" required data-validation-required-message="Please Status">
                                                                    <option value="">Select Status</option>
                                                                        <?php 
                                                                            $stat = new DbaseManipulation;
                                                                            $rows = $stat->readData("SELECT * FROM status WHERE active = 1");
                                                                            foreach ($rows as $row) {
                                                                                ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                <?php            
                                                                            }    
                                                                        ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-3 control-label"><span class="text-danger">*</span>Leave Date</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <!--<input type="date"  class="form-control"/>   -->
                                                                <input type="text" class="form-control" name="leaveDate" id="mdate" required data-validation-required-message="Please enter leave date"/>
                                                                
                                                                <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                                <span class="far fa-calendar-alt"></span>
                                                                        </span>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <?php 
                                                        $request = new DbaseManipulation;
                                                        $requestNo = $request->requestNo("SKP-","clearance_skip");
                                                    ?>
                                                    <label for="" class="col-sm-3 control-label">Request ID</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="requestNo" value="<?php echo $requestNo; ?>"  readonly />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-3 control-label">Enter By</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="<?php echo $logged_name ?>" disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Enter Date</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i:s') ?>" disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Open modal</button>-->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------------------------------------------>
                                <!------------------------------------------------------------------------>
                                <div class="col-lg-8"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">List of Skip Clearance Request</h4>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Req Id</th>
                                                            <th>Staff ID</th>
                                                            <th>Staff Name</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Leave Date</th>
                                                            <th>Enter Date</th>
                                                            <th>Enter By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sql = "SELECT c.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, concat(f.firstName,' ',f.secondName,' ',f.thirdName,' ',f.lastName) as filedBy, d.name as department, sts.name as status FROM clearance_skip as c LEFT OUTER JOIN staff as s ON c.staffId = s.staffId LEFT OUTER JOIN staff as f ON c.enteredBy = f.staffId LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN status as sts on e.status_id = sts.id";
                                                            $list = new DbaseManipulation;
                                                            $rows = $list->readData($sql);
                                                            $i = 0;
                                                            foreach ($rows as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo ++$i; ?></td>
                                                                    <td><a href=""><?php echo $row['staffId']; ?></a></td>
                                                                    <td><a href=""><?php echo $row['staffName']; ?></a></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['status'] ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['leaveDate'])); ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['dateEntered'])); ?></td>
                                                                    <td><?php echo $row['filedBy']; ?></td>
                                                                </tr>
                                                                <?php
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
                <?php include('include_scripts.php'); ?>
                <script>
                    // MAterial Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    
                </script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Clearance has been filed and saved successfully!</h5>
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