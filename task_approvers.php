<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
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
                        <?php include('menu_top.php'); ?>
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Task Approvers</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Task</li>
                                        <li class="breadcrumb-item">Task Approvers</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-sm-18">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Task Approver Form</h3>
                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                                $nextId = new DbaseManipulation;
                                                $result = $nextId->singleReadFullQry("SELECT TOP 1 id FROM taskapprover ORDER BY id DESC");

                                                if(isset($_POST['submit'])){
                                                    $save = new DbaseManipulation;
                                                    $task_id = $save->cleanString($_POST['task_id']);
                                                    $staff_id = $save->cleanString($_POST['staff_id']);
                                                    $department_id = $save->employmentIDs($staff_id,'department_id');
                                                    $status = $save->cleanString($_POST['status']);
                                                    $notes = $save->cleanString($_POST['notes']);
                                                    $createdBy = $save->cleanString($_POST['createdBy']);
                                                    $created = date('Y-m-d H:i:s',time());

                                                    $fields = [
                                                        'task_id'=>$task_id,
                                                        'staff_id'=>$staff_id,
                                                        'department_id'=>$department_id,
                                                        'status'=>$status,
                                                        'notes'=>$notes,
                                                        'createdBy'=>$createdBy,
                                                        'created'=>$created
                                                    ];
                                                    $save->insert("taskapprover",$fields);
                                                    //echo $save->displayArr($fields);
                                            ?>
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                        <p>Task has been assigned to the selected approver.</p>
                                                    </div>
                                            <?php
                                                }
                                            ?>
                                            
                                            <form class="form-horizontal p-t-20 p-l-0 p-" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label">Approver ID</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="id" value="<?php echo $result['id'] + 1; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label"><span class="text-danger">*</span>Task Section</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="task_id" class="form-control" required data-validation-required-message="Please select task section">
                                                                    <option value="">Select Task Section</option>
                                                                    <?php 
                                                                        $taskList = new DbaseManipulation;
                                                                        $rows = $taskList->readData("SELECT * FROM tasklist");
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
                                                    <label class="col-lg-3 control-label"><span class="text-danger">*</span>Approver</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="staff_id" class="form-control" required data-validation-required-message="Please select approver of this section on Task">
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
                                                    <label class="col-lg-3 control-label"><span class="text-danger">*</span>Status</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="status" class="form-control" required data-validation-required-message="Please select status">
                                                                    <option value="">Select Status</option>
                                                                    <option value="Active">Active</option>
                                                                    <option value="Not-Active">Not-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label">Notes / Comments</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <textarea name="notes" class="form-control" rows="2"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
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
                                                                <input type="text" name="createdBy" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label">Date Entered</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="created" class="form-control" value="<?php echo date('d/m/Y H:i:s',time()); ?>" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><span class="far fa-calendar-alt"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-lg-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-7 col-sm-18">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h4 class="card-title">Task Approver List</h4>
                                                    <h6 class="card-subtitle">Arabic Text Here....</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Approver Name</th>
                                                            <th>Task Section</th>
                                                            <th>Status</th>
                                                            <th>Entered By</th>
                                                            <th>Date Entered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $approvers = new DbaseManipulation;
                                                            $rows = $approvers->readData("SELECT a.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, t.name as taskList, concat(c.firstName,' ',c.secondName,' ',c.thirdName,' ',c.lastName) as created_by FROM taskapprover as a LEFT OUTER JOIN staff as s ON a.staff_id = s.staffId LEFT OUTER JOIN tasklist as t ON a.task_id = t.id LEFT OUTER JOIN staff as c ON a.createdBy = c.staffId ORDER BY a.task_id");
                                                            foreach($rows as $row) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $row['id']; ?></td>
                                                                    <td><a href="task_approvers_edit.php?id=<?php echo $row['id']; ?>"><?php echo $row['staffName']; ?></a></td>
                                                                    <td><?php echo $row['taskList']; ?></td>
                                                                    <td><?php echo $row['status']; ?></td>
                                                                    <td><?php echo $row['created_by']; ?></td>
                                                                    <td><?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?></td>
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
                            <?php
                                include('include_footer.php'); 
                            ?>
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