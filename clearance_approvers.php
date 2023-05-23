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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Approvers</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance</li>
                                        <li class="breadcrumb-item">Clearance Approvers</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-18">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Clearance Approver Form</h3>
                                                    <h6 class="card-subtitle">إستمارة معتمد إخلاء الطرف</h6>
                                                </div>
                                            </div>

                                            <form class="form-horizontal " action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label">Approver ID</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="numberofdays" class="form-control" readonly>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label"><span class="text-danger">*</span>Clearance Section</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select class="form-control" required data-validation-required-message="Please select Clearance Section">
                                                                    <option value="">Select Clearance Section</option>
                                                                    <option>Assistant Dean for Admin and Financial Affairs</option>
                                                                    <option>Human Resource</option>
                                                                    <option>Administrative Affairs</option>
                                                                    <option>Financial Affairs</option>
                                                                    <option>Educational Technologies Centre</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label"><span class="text-danger">*</span>Approver</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select class="form-control" required data-validation-required-message="Please select approver of this section on clearance">
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
                                                    <label class="col-lg-3 control-label"><span
                                                            class="text-danger">*</span>Status</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select class="form-control" required data-validation-required-message="Please select status">
                                                                    <option value="">Select Status</option>
                                                                    <option>Active</option>
                                                                    <option>Not-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label">Notes/ Comments</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <textarea class="form-control" rows="2"></textarea>
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
                                                    <label class="col-lg-3 control-label">Entered By</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="" value="<?php echo $logged_name; ?>" class="form-control" readonly>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-user"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label">Enter Date</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="" class="form-control" value="<?php echo date('d/m/Y H:i:s'); ?>" readonly>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                       
                                                </div>                                    
                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-lg-9">
                                                        <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-18">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Clearance Approver List <small>These entry will approve clearance in no particular order.</small></h4>
                                            <h6 class="card-subtitle">قائمة معتمدي إخلاء الطرف</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>ID</th>
                                                            <th>Clearance Section</th>
                                                            <th>Approver Name</th>
                                                            <th>Sequence</th>
                                                            <th>Enter By</th>
                                                            <th>Entered Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $rows = $helper->readData("
                                                            SELECT ca.*, e.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.title as position, d.name as clearanceSection 
                                                            FROM clearance_approver as ca 
                                                            LEFT OUTER JOIN employmentdetail as e ON ca.position_id = e.position_id 
                                                            LEFT OUTER JOIN staff as s ON e.staff_id = s.staffId 
                                                            LEFT OUTER JOIN staff_position as sp ON e.position_id = sp.id 
                                                            LEFT OUTER JOIN department as d ON e.department_id = d.id 
                                                            WHERE e.isCurrent = 1 AND e.status_id = 1 ORDER BY ca.id, ca.active");
                                                            if($helper->totalCount != 0) {
                                                                $i = 0;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo ++$i.'.'; ?></td>
                                                                    <td>-</td>
                                                                    <td>Head of Section</td>
                                                                    <td>-</td>
                                                                    <td>1</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo ++$i.'.'; ?></td>
                                                                    <td>-</td>
                                                                    <td>Head of Center/Department</td>
                                                                    <td>-</td>
                                                                    <td>2</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <?php
                                                                foreach($rows as $row) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td><a href="?linkid=<?php echo $_GET['linkid']; ?>&id=<?php echo $row['staff_id']; ?>" title="Click to view/edit Approver Details"><?php echo $row['staff_id'] ?></a>
                                                                            </td>
                                                                            <td><?php echo $row['clearanceSection']; ?></td>
                                                                            <td><?php echo $row['staffName']; ?></td>
                                                                            <td><?php echo $row['sequence_no']; ?></td>
                                                                            <td><?php echo $row['created_by']; ?></td>
                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?></td>
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
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>