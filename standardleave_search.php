<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;
?>
            <body class="fix-header fix-sidebar card-no-border">
                
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Search Staff Leave</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Standard Leave</li>
                                        <li class="breadcrumb-item active">Search Staff Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-outline-info">
                                        <div class="card-header">
                                            <h4 class="m-b-0 text-white"><i class="far fa-calendar-alt"></i> Search Standard Leave Form</h4>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" action="" method="POST">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Staff ID</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="staff_id[]" id="staff_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Staff Name">
                                                                            <option value="">Select Here</option>
                                                                            <?php 
                                                                                $managers = new DbaseManipulation;
                                                                                $rows = $managers->readData($SQLActiveStaff);
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['staffId']; ?>"><?php echo $row['staffId'].' - '.preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sponsor_id[]" id="sponsor_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Sponsor">
                                                                            <option value="999">All Company</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM sponsor ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sponsor_id').value = "<?php echo $_POST['sponsor_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="department_id[]" id="department_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Department">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM department ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('department_id').value = "<?php echo $_POST['department_id'];?>";
                                                                         </script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="section_id[]" id="section_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Section">
                                                                            
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM section ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('section_id').value = "<?php echo $_POST['section_id'];?>";
                                                                         </script>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">College Position</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="position_id[]" id="position_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select College Position">
                                                                        <?php 
                                                                            $rows = $dropdown->readData("SELECT id, code, title FROM staff_position ORDER BY id");
                                                                            foreach ($rows as $row) {
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                        <?php            
                                                                            }    
                                                                        ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('position_id').value = "<?php echo $_POST['position_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Leave Type</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="leavetype_id[]" id="leavetype_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Leave Type">
                                                                        <?php 
                                                                            $rows = $dropdown->readData("SELECT id, name FROM leavetype ORDER BY id");
                                                                            foreach ($rows as $row) {
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                        <?php            
                                                                            }    
                                                                        ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('leavetype_id').value = "<?php echo $_POST['leavetype_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Application Date</label>
                                                            <div class="col-sm-8">
                                                                <div class='input-group mb-3'>
                                                                    <input type="text" name="daterange" class="form-control daterange" />
                                                                    <input type="hidden" name="startDate" class="form-control startDate" />
                                                                    <input type="hidden" name="endDate" class="form-control endDate" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <span class="far fa-calendar-alt"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="leavestatus[]" id="leavestatus" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Leave Status">
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Approved">Approved</option>
                                                                            <option value="Declined">Declined</option>
                                                                            <option value="Cancelled">Cancelled</option>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('leavestatus').value = "<?php echo $_POST['leavestatus'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-b-0">
                                                            <div class="offset-sm-4 col-sm-8">
                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                        if(isset($_POST['submit'])){
                                            //print_r($_POST);
                                            $sql = "
                                            SELECT st.id, st.requestNo, st.currentStatus, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                            d.name as department, sc.name as section, sps.name as sponsor, lt.name as leaveCategory, st.dateFiled, st.startDate, st.endDate, st.total, st.currentStatus
                                            FROM standardleave as st 
                                            LEFT OUTER JOIN employmentdetail as e ON st.staff_id = e.staff_id 
                                            LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                            LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                                            LEFT OUTER JOIN sponsor as sps ON sps.id = e.sponsor_id 
                                            LEFT OUTER JOIN leavetype as lt ON lt.id = st.leavetype_id 
                                            LEFT OUTER JOIN staff as s ON s.staffId = st.staff_id
                                            WHERE e.isCurrent = 1 AND ";

                                            if ($_POST['department_id'] == 0) {
                                                $sql .= "e.department_id > 0";
                                            } else {
                                                $departmentIds = array();
                                                foreach ($_POST['department_id'] as $selectedDepartmentIds) {
                                                    array_push($departmentIds,$selectedDepartmentIds);
                                                }
                                                $departmentIds = implode(', ', $departmentIds);
                                                $sql .= "e.department_id IN (".$departmentIds.")";
                                            }
                                            if ($_POST['sponsor_id'] != '') {
                                                if($_POST['sponsor_id'] == 999)
                                                    $sql .= " AND e.sponsor_id != 1";
                                                else
                                                    $sponsorIds = array();
                                                    foreach ($_POST['sponsor_id'] as $selectedSponsorIds) {
                                                        array_push($sponsorIds,$selectedSponsorIds);
                                                    }
                                                    $sponsorIds = implode(', ', $sponsorIds);
                                                    $sql .= " AND e.sponsor_id IN (".$sponsorIds.")";
                                            }

                                            if ($_POST['section_id'] != '') {
                                                $sectionIds = array();
                                                foreach ($_POST['section_id'] as $selectedSectionIds) {
                                                    array_push($sectionIds,$selectedSectionIds);
                                                }
                                                $sectionIds = implode(', ', $sectionIds);
                                                $sql .= " AND e.section_id IN (".$sectionIds.")";
                                            }

                                            if ($_POST['position_id'] != '') {
                                                $positionIds = array();
                                                foreach ($_POST['position_id'] as $selectedPositionIds) {
                                                    array_push($positionIds,$selectedPositionIds);
                                                }
                                                $positionIds = implode(', ', $positionIds);
                                                $sql .= " AND e.position_id IN (".$positionIds.")";
                                            }
                                            
                                            if ($_POST['leavetype_id'] != '') {
                                                $leaveTypeIds = array();
                                                foreach ($_POST['leavetype_id'] as $selectedPositionIds) {
                                                    array_push($leaveTypeIds,$selectedPositionIds);
                                                }
                                                $leaveTypeIds = implode(', ', $leaveTypeIds);
                                                $sql .= " AND st.leavetype_id IN (".$leaveTypeIds.")";
                                            }
                                            

                                            if ($_POST['leavestatus'] != '') {
                                                $sCurrentStatus = array();
                                                foreach ($_POST['leavestatus'] as $selectedsMaritalIds) {
                                                    array_push($sCurrentStatus,$selectedsMaritalIds);
                                                }
                                                $sCurrentStatus = "'" .implode("', '", $sCurrentStatus). "'";
                                                $sql .= " AND st.currentStatus IN (".$sCurrentStatus.")";
                                            }
                                            if ($_POST['startDate'] != '') {
                                                $startDeyt = $_POST['startDate'];
                                                $endDeyt = $_POST['endDate'];
                                                $sql .= " AND st.startDate >= '".$startDeyt."' AND st.endDate <= '".$endDeyt."'";
                                            }
                                            if ($_POST['staff_id'] != '') {
                                                $sStaffIds = array();
                                                foreach ($_POST['staff_id'] as $selectedsMaritalIds) {
                                                    array_push($sStaffIds,$selectedsMaritalIds);
                                                }
                                                $sStaffIds = "'" .implode("', '", $sStaffIds). "'";
                                                $sql .= " AND s.staffId IN (".$sStaffIds.")";
                                            }
                                            //echo $sql;
                                            ?>                                            
                                            <div class="card card-outline-info">
                                                <h5 class="card-header m-b-0 text-white">Search Result</h5>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Request ID</th>
                                                                    <th>Staff ID</th>
                                                                    <th>Name</th>
                                                                    <th>Department</th>
                                                                    <th>Section</th>
                                                                    <th>Sponsor</th>
                                                                    <th>Leave Category</th>
                                                                    <th>Date Filed</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Days</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    $data = new DbaseManipulation;
                                                                    $rows = $data->readData($sql); // WHERE e.isCurrent = 1 AND e.status_id = 1 means all active staff
                                                                    foreach ($rows as $row) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><a href="standardleave_details.php?id=<?php echo $row['requestNo'] ?>&uid=<?php echo $row['staffId'] ?>"><?php echo $row['requestNo'] ?></a></td>
                                                                            <td><?php echo $row['staffId'] ?></td>
                                                                            <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['section']; ?></td>
                                                                            <td><?php echo $row['sponsor']; ?></td>
                                                                            <td><?php echo $row['leaveCategory']; ?></td>
                                                                            <td><?php echo date('d/m/Y',strtotime($row['dateFiled'])); ?></td>
                                                                            <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                            <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                            <td><?php echo $row['total']; ?></td>
                                                                            <td><?php echo $row['currentStatus']; ?></td>
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
                                        }
                                    ?>        
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