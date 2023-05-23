<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
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
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">System File Maintenance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">File Maintenance</li>
                                        <li class="breadcrumb-item">System User</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Add New System User</h3>
                                                    <h6 class="card-subtitle">اضافة مستخدم نظام جديد</h6> 
                                                </div>
                                            </div>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $save = new DbaseManipulation;
                                                    $staff_id = $save->cleanString($_POST['staff_id']);
                                                    $row = $helper->singleReadFullQry("SELECT * FROM users WHERE username = '$staff_id'");
                                                    if($helper->totalCount != 0) {
                                                        ?>
                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Unable to continue!</h4>
                                                                <p>Selected staff have already an existing user access. Kindly check the name in the list.</p>
                                                            </div>
                                                        <?php
                                                    } else {
                                                            $user_type_id = $save->cleanString($_POST['user_type_id']);
                                                            $active = $save->cleanString($_POST['active']);

                                                            $fields = [
                                                                'username'=>$staff_id,
                                                                'password'=>md5(1),
                                                                'userType'=>$user_type_id,
                                                                'status'=>$active,
                                                                'created_by'=>$staffId,
                                                                'created'=>date('Y-m-d H:i:s', time()),
                                                                'modified'=>date('Y-m-d H:i:s', time())
                                                            ];
                                                            
                                                            if($save->insert("users",$fields)) {
                                                                ?>            
                                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                    <p>New user access has been added and saved.</p>
                                                                </div>
                                                                <?php
                                                            }
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
                                                                    <option value="">Select Here</option>
                                                                    <?php
                                                                        $rows = $helper->readData("SELECT e.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM employmentdetail as e LEFT OUTER JOIN staff as s ON s.staffId = e.staff_id WHERE e.status_id = 1 AND e.isCurrent = 1 ORDER BY staffName");
                                                                        foreach($rows as $row){
                                                                            ?>
                                                                                <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['staffName']; ?></option>
                                                                            <?php        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            
    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>User Type</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="user_type_id" class="form-control" required data-validation-required-message="Please select User Type from the list">
                                                                    <option value="">Select Here</option>
                                                                    <?php
                                                                        $rows = $helper->readData("SELECT * FROM user_types WHERE active = 1");
                                                                        foreach($rows as $row){
                                                                            ?>
                                                                                <option value="<?php echo $row['user_type_id']; ?>"><?php echo $row['name']; ?></option>
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
                                                                <select name="active" class="form-control" required data-validation-required-message="Please select either ACTIVE or NOT-Active from this list">
                                                                    <option value="">Select Here</option>
                                                                    <option value="1">Active</option>
                                                                    <option value="0">Not-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------------------------------------------>
                                <!------------------------------------------------------------------------>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">System User List</h4>
                                            <h6 class="card-subtitle">قائمة مستخدمي النظام</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Staff ID</th>
                                                            <th>Staff Name</th>
                                                            <th>User Type</th>
                                                            <th>Active</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 0;  
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("SELECT u.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, ut.name as user_type_name FROM users as u LEFT OUTER JOIN staff as s ON s.staffId = u.username LEFT OUTER JOIN user_types as ut ON ut.user_type_id = u.userType LEFT OUTER JOIN employmentdetail as e ON e.staff_id = u.username WHERE e.status_id = 1 AND e.isCurrent = 1 ORDER BY staffName");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo ++$i.'.'; ?></td>
                                                                    <td><a href="file_users_edit.php?id=<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a></td>
                                                                    <td><?php echo $row['staffName']; ?></td>
                                                                    <td><?php echo $row['user_type_name']; ?></td>
                                                                    <td><?php echo $row['status'] ? "YES" : "NO"; ?></td>
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
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Success</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        New department has been added and saved.
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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