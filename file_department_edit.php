<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $department = new DbaseManipulation;
                $result = $department->singleRead("department",$id);
                $field = $department->fieldNameValue("department",$id,'id');
            }                                 
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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Department File Maintenance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">File Maintenance</li>
                                        <li class="breadcrumb-item">Department</li>
                                        <li class="breadcrumb-item">Edit Department</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6"><!---start form div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Edit Department</h3>
                                                    <h6 class="card-subtitle">تحرير القسم</h6> 
                                                </div>
                                            </div>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $save = new DbaseManipulation;
                                                    $id = $save->cleanString($_POST['id']);
                                                    $name = $save->cleanString($_POST['name']);
                                                    $shortName = $save->cleanString($_POST['shortName']);
                                                    $isAcademic = $save->cleanString($_POST['isAcademic']);
                                                    $managerId = $save->cleanString($_POST['managerId']);
                                                    $active = $save->cleanString($_POST['active']);

                                                    if($active == 1) {
                                                        $fields = [
                                                            'name'=>$name,
                                                            'shortName'=>$shortName,
                                                            'isAcademic'=>$isAcademic,
                                                            'managerId'=>$managerId,
                                                            'active'=>$active
                                                        ];
                                            
                                                        if($save->update("department",$fields,$id)) {
                                            ?>            
                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                <p>Department has been modified and updated.</p>
                                                            </div>
                                            <?php
                                                        }
                                                    } else {
                                                        $errorCounter = 0;
                                                        $checkEmploymentTable = new DbaseManipulation;
                                                        $empCheck = $checkEmploymentTable->singleReadFullQry("SELECT count(department_id) as department_id FROM employmentdetail WHERE department_id = $id AND isCurrent = 1 AND status_id = 1");
                                                        if($empCheck['department_id'] > 0) {
                                                            $errorCounter = 1;
                                                            $msgPrompt = "Unable to deactivate department. There are staff records in the system that belongs to this department, kindly change their department first before deactivating.";        
                                                        } else {
                                                            $checkSectionTable = new DbaseManipulation;
                                                            $sectionCheck = $checkSectionTable->singleReadFullQry("SELECT count(department_id) as department_id FROM section WHERE department_id = $id AND active = 1");
                                                            if($sectionCheck['department_id'] > 0) {
                                                                $errorCounter = 1;
                                                                $msgPrompt = "Unable to deactivate department. There are sections in the system that belongs to this department, kindly change their department first before deactivating.";        
                                                            }
                                                        }
                                                        if($errorCounter != 0) {
                                            ?>
                                                            <!-- Show this prompt as long as all the conditions above is always TRUE -->
                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Failure!</h4>
                                                                <p><?php echo $msgPrompt; ?></p>
                                                            </div>                
                                            <?php       
                                                        } else {
                                                            $fields = [
                                                                'name'=>$name,
                                                                'shortName'=>$shortName,
                                                                'isAcademic'=>$isAcademic,
                                                                'managerId'=>$managerId,
                                                                'active'=>$active
                                                            ];
                                                            if($save->update("department",$fields,$id)) {
                                            ?>
                                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                    <p>Department has been modified and updated.</p>
                                                                </div>
                                            <?php                
                                                            }    
                                                        } 
                                                    }
                                                }
                                            ?>
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Department Id<br>رقم القسم</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                                                <input type="text" name="uid" value="<?php echo $field; ?>" class="form-control" required data-validation-required-message="Please type the department Id" readonly /> 
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Name<br>إسم القسم</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="name" value="<?php echo $result['name']; ?>" class="form-control" required data-validation-required-message="Please type the department name" /> 
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Short Name<br>الإسم المختصر</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="shortName" value="<?php echo $result['shortName']; ?>" class="form-control" required data-validation-required-message="Please type the department's short name" />
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Manager<br>الرئيس</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="managerId" class="form-control select2" required data-validation-required-message="Please select manager from the list">
                                                                    <option value="">Select Manager Here</option>
                                                                    <?php 
                                                                        $managers = new DbaseManipulation;
                                                                        $rows = $managers->readData($SQLActiveStaff);
                                                                        foreach ($rows as $row) {
                                                                            if($result['managerId'] == $row['staffId']) {
                                                                    ?>
                                                                                <option value="<?php echo $result['managerId']; ?>" selected><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                    <?php            
                                                                            } else {
                                                                    ?>
                                                                                <option value="<?php echo $row['staffId']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                    <?php           
                                                                            } 
                                                                        }    
                                                                    ?>
                                                                </select>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Is Academic?<br>أكاديمي؟</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="isAcademic" class="form-control select2" required data-validation-required-message="Please select either YES or NO from this list">
                                                                    <option value="">Select Value Here</option>
                                                                    <?php 
                                                                        for($i=0; $i <=1; $i++) {
                                                                            if($result['isAcademic'] == $i) {
                                                                                if($result['isAcademic'] == 1) {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" selected> YES</option>
                                                                    <?php
                                                                                } else {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" selected> NO</option>
                                                                    <?php
                                                                                }                        
                                                                            } else {
                                                                                if($result['isAcademic'] == 1) {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>"> NO</option>       
                                                                    <?php
                                                                                } else {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>"> YES</option>       
                                                                    <?php              
                                                                                }
                                                                            }        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Active<br>الحالة</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="active" class="form-control select2" required data-validation-required-message="Please select either YES or NO from this list">
                                                                    <option value="">Select Value Here</option>
                                                                    <?php 
                                                                        for($i=0; $i <=1; $i++) {
                                                                            if($result['active'] == $i) {
                                                                                if($result['active'] == 1) {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" selected> YES</option>
                                                                    <?php
                                                                                } else {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" selected> NO</option>
                                                                    <?php
                                                                                }                        
                                                                            } else {
                                                                                if($result['active'] == 1) {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>"> NO</option>       
                                                                    <?php
                                                                                } else {
                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>"> YES</option>       
                                                                    <?php              
                                                                                }
                                                                            }        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row -->

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-edit"></i> Update</button>
                                                        <a href="file_department.php" class="btn btn-success waves-effect waves-light"><i class="fa fa-file"></i> Add New</a>
                                                        <!-- <a href="" class="btn btn-danger waves-effect waves-light delete-confirm" delete-id="<?php //echo $result['id']; ?>" deleting="department"><i class="fa fa-times"></i> Delete</a> -->
                                                    </div>
                                                </div>
                                            </form><!--end form-->
                                        </div><!--end card body-->
                                    </div><!--end card-->
                                </div><!--end col-lg-6-->
                                <!------------------------------------------------------------------------>
                                <!------------------------------------------------------------------------>

                                <div class="col-lg-6"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Department Names List</h4>
                                            <h6 class="card-subtitle">قائمة أسماء الأقسام</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Department Name</th>
                                                            <th>Short Name</th>
                                                            <th>Manager</th>
                                                            <th>Active</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("SELECT * FROM department");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $row['id']; ?></td>
                                                                    <td><a href="file_department_edit.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                                                                    <td><?php echo $row['shortName']; ?></td>
                                                                    <td><?php echo $row['managerId']; ?></td>
                                                                    <td><?php echo $row['active'] ? "YES" : "NO"; ?></td>
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
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>