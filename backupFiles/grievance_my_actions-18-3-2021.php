<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $staffId == '119084' || $staffId == '121101' || $staffId == '107036') ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                     <?php    include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Grievance List [With My Actions] </h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Grievance  </li>
                                        <li class="breadcrumb-item">Grievance List</li>
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
                                                        <select class="custom-select select2">
                                                            <option value="">All </option>
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

                                                <label class="col-md-2 col-form-label">Complaint Type</label>
                                                <div class="col-md-2">
                                                    <div class="controls">
                                                        <select class="form-control">
                                                            <option value="">All Complaint Type</option>
                                                            <option value="1">Academic</option>
                                                            <option value="2">Administrative</option>
                                                            <option value="3">Personal</option>
                                                            <option value="4">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-5 m-t-0">
                                                <label class="col-md-1 col-form-label">Department</label>
                                                <div class="col-md-3">
                                                    <div class="controls">
                                                        <select class="custom-select select2">
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
                                                        <select class="custom-select select2">
                                                            <option value="">All Status</option>
                                                            <option value="OPEN">Open</option>
                                                            <option value="SOLVED">Solved</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 ">
                                                    <button class="btn btn-success waves-effect waves-light" name="submit" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-------------------------------------------------->
                            <div class="row"><!--for result-->
                                <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                    <div class="card bg-light-warning2">
                                        <div class="card-header bg-light-warning2 p-b-0 p-t-5" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Grievance List with My Actions</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Complainant Name</th>
                                                            <th>Department</th>
                                                            <th>Respondent Name</th>
                                                            <th>Complaint Type</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            if(isset($POST['submit'])) {
                                                                $sql = '';
                                                            } else {
                                                                $sql = "SELECT g.*, d.name as department, concat(c.firstName,' ',c.secondName,' ',c.thirdName,' ',c.lastName) as complainant, concat(r.firstName,' ',r.secondName,' ',r.thirdName,' ',r.lastName) as responder
                                                                    FROM grievance as g 
                                                                    LEFT OUTER JOIN employmentdetail as e ON e.staff_id = g.complainant
                                                                    LEFT OUTER JOIN staff as c ON c.staffId = g.complainant
                                                                    LEFT OUTER JOIN staff as r ON r.staffId = g.responder
                                                                    LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                    WHERE g.current_approver_id = $myPositionId AND e.isCurrent = 1 ORDER BY g.id";
                                                            }
                                                            $myActions = new DbaseManipulation;
                                                            $rows = $myActions->readData($sql);
                                                            //echo $myActions->totalCount;
                                                            if($myActions->totalCount != 0) {
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
                                                                            $complaint_type = 'Administrative';
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
                                                                        <td><a href="grievance_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['complainant']; ?></a></td>
                                                                        <td><?php echo $row['department']; ?></td>
                                                                        <td><?php echo $row['responder']; ?></td>
                                                                        <td><?php echo $complaint_type; ?></td>
                                                                        <td><?php echo date('d/m/Y h:i:s A',strtotime($row['date_filed'])); ?></td>
                                                                        <td><?php echo $row['status']; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                //May mali dito sa e.section_id kapag ang naka login ay HoD
                                                                if($user_type == 3) {
                                                                        $sql2 = "SELECT g.*, d.name as department, concat(c.firstName,' ',c.secondName,' ',c.thirdName,' ',c.lastName) as complainant, concat(r.firstName,' ',r.secondName,' ',r.thirdName,' ',r.lastName) as responder
                                                                        FROM grievance as g 
                                                                        LEFT OUTER JOIN employmentdetail as e ON e.staff_id = g.complainant
                                                                        LEFT OUTER JOIN staff as c ON c.staffId = g.complainant
                                                                        LEFT OUTER JOIN staff as r ON r.staffId = g.responder
                                                                        LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                        WHERE e.isCurrent = 1 AND e.department_id = $logged_in_department_id ORDER BY g.id";
                                                                } else if ($user_type == 4) {
                                                                        $sql2 = "SELECT g.*, d.name as department, concat(c.firstName,' ',c.secondName,' ',c.thirdName,' ',c.lastName) as complainant, concat(r.firstName,' ',r.secondName,' ',r.thirdName,' ',r.lastName) as responder
                                                                        FROM grievance as g 
                                                                        LEFT OUTER JOIN employmentdetail as e ON e.staff_id = g.complainant
                                                                        LEFT OUTER JOIN staff as c ON c.staffId = g.complainant
                                                                        LEFT OUTER JOIN staff as r ON r.staffId = g.responder
                                                                        LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                        WHERE e.isCurrent = 1 AND e.department_id = $logged_in_department_id AND e.section_id = $logged_in_section_id
                                                                        ORDER BY g.id";
                                                                }        
                                                                    $myPrevActions = new DbaseManipulation;
                                                                    $rows = $myPrevActions->readData($sql2);
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
                                                                                $complaint_type = 'Administrative';
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
                                                                            <td><a href="grievance_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['complainant']; ?></a></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['responder']; ?></td>
                                                                            <td><?php echo $complaint_type; ?></td>
                                                                            <td><?php echo date('d/m/Y h:i:s A',strtotime($row['date_filed'])); ?></td>
                                                                            <td><?php echo $row['status']; ?></td>
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