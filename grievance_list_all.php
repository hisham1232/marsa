<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed =  true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
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
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Grievance List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Grievance  </li>
                                        <li class="breadcrumb-item">All Grievance List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <!------------------------------------------------->
                            <div class="row">
                                <div class="col-lg-12 col-md-18 col-xs-18">
                                    <div class="card card-body p-b-0 bg-light-warning">
                                        <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row m-b-5 m-t-0">
                                                <label class="col-md-1 col-form-label">Staff</label>
                                                <div class="col-md-3">
                                                    <div class="controls">
                                                        <select name="staff_id" class="custom-select select2">
                                                            <option value="">All Staff</option>
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

                                                <label class="col-md-1 col-form-label">Date</label>
                                                <div class="col-md-2">
                                                    <div class="controls">
                                                        <input type='text' class="form-control daterange"/>
                                                    </div>
                                                </div>

                                                <label class="col-md-2 col-form-label" style="display: none">Complaint Type</label>
                                                <div class="col-md-2" style="display: none">
                                                    <div class="controls">
                                                        <select name="complaint_type" class="form-control">
                                                            <option value="">All Complaint Type</option>
                                                            <option value="1">Academic</option>
                                                            <option value="2">Non-Academic</option>
                                                            <!-- <option value="3">Personal</option>
                                                            <option value="4">Other</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-5 m-t-0">
                                                <label class="col-md-1 col-form-label">Department</label>
                                                <div class="col-md-3">
                                                    <div class="controls">
                                                        <select name="department_id" class="form-control">
                                                            <option value="">All Department</option>
                                                            <?php 
                                                                $department = new DbaseManipulation;
                                                                $rows = $department->readData("SELECT id, name FROM department ORDER BY id");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label class="col-md-1 col-form-label">Status</label>
                                                <div class="col-md-2">
                                                    <div class="controls">
                                                        <select name="status" class="form-control">
                                                            <option value="">All Status</option>
                                                            <option value="OPEN">Open</option>
                                                            <option value="CLOSED">Closed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 ">
                                                    <button class="btn btn-success waves-effect waves-light" type="submit" name="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------------->

                            <div class="row"><!--for result-->
                                <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                    <div class="card bg-light-warning2">
                                        <div class="card-header bg-light-warning2" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Grievance List</h4>
                                            
                                        </div><!--end card header-->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Complainant Name</th>
                                                            <th>Department</th>
                                                            <th>Respondent Name</th>
                                                            <!-- <th>Complaint Type</th> -->
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Interval</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $myGrievance = new DbaseManipulation;
                                                            if(isset($_POST['submit'])) {
                                                                $sql = "SELECT g.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as responderName, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as complainantName, d.name as department
                                                                    FROM grievance as g 
                                                                    LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id
                                                                    LEFT OUTER JOIN staff as s ON g.responder = s.staffId 
                                                                    LEFT OUTER JOIN staff as ss ON g.complainant = ss.staffId 
                                                                    LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE e.isCurrent = 1 ";

                                                                    if ($_POST['department_id'] != '') {
                                                                        $sql .= " AND e.department_id = '".$_POST['department_id']."'";
                                                                    } else {
                                                                        $sql .= " AND e.department_id > 0";
                                                                    }

                                                                    if ($_POST['status'] != '') {
                                                                        $sql .= " AND g.status = '".$_POST['status']."'";
                                                                    } else {
                                                                        $sql .= " AND g.status IN ('OPEN','CLOSED')";
                                                                    }

                                                                    if ($_POST['complaint_type'] != '') {
                                                                        $sql .= " AND g.complaint_type = '".$_POST['complaint_type']."'";
                                                                    } else {
                                                                        $sql .= " AND g.complaint_type > 0";
                                                                    }

                                                                    if ($_POST['staff_id'] != '') {
                                                                        $sql .= " AND g.complainant = '".$_POST['staff_id']."'";
                                                                    } else {
                                                                        $sql .= " AND g.complainant > 0";
                                                                    }                                                                    
                                                            } else {
                                                                $sql = "SELECT g.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as responderName, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as complainantName, d.name as department
                                                                    FROM grievance as g 
                                                                    LEFT OUTER JOIN employmentdetail as e ON g.responder = e.staff_id
                                                                    LEFT OUTER JOIN staff as s ON g.responder = s.staffId 
                                                                    LEFT OUTER JOIN staff as ss ON g.complainant = ss.staffId 
                                                                    LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE e.isCurrent = 1 ORDER BY status DESC, id DESC";
                                                            }
                                                            //echo $sql;
                                                            $rows = $myGrievance->readData($sql);
                                                            $i = 0;
                                                                foreach ($rows as $row) {
                                                                    if($row['status'] == 'OPEN') {
                                                                        $class = 'text-danger';
                                                                    } else {
                                                                        $class = 'none';
                                                                    }
                                                                    switch($row['complaint_type']){
                                                                        case 1:
                                                                            $complaint_type = 'Academic';
                                                                        break;
                                                                        case 2:
                                                                            $complaint_type = 'Non-Academic';
                                                                        break;
                                                                        case 3:
                                                                            $complaint_type = 'Personal';
                                                                        break;
                                                                        case 4:
                                                                            $complaint_type = 'Others';
                                                                        break;
                                                                        default:
                                                                            $complaint_type = '';
                                                                        break;
                                                                    }
                                                                    ?>
                                                                        <tr class="<?php echo $class; ?>">
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td><a href="grievance_details_read.php?id=<?php echo $row['id']; ?>"><?php echo $row['complainantName']; ?></a></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['responderName']; ?></td>
                                                                            <!-- <td><?php //echo $complaint_type; ?></td> -->
                                                                            <td><?php echo date('d/m/Y h:i:s A',strtotime($row['date_filed'])); ?></td>
                                                                            <td><?php echo $row['status']; ?></td>
                                                                            <td>
                                                                                <?php 
                                                                                    $now_date = date('Y-m-d',time());
                                                                                    $date1 = $row['date_filed'];
                                                                                    $date2 = $now_date;
                                                                                    $diff = abs(strtotime($date2) - strtotime($date1));
                                                                                    $years = floor($diff / (365*60*60*24));
                                                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                                                    echo $days.' Days';
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php 
                                                                    }
                                                                ?>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                        </div><!--end card body-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-6-->
                            </div><!--end row-->
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
                    // MAterial Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });
                    $('.daterange').daterangepicker();
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>