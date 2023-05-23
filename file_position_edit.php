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
                $staff_position = new DbaseManipulation;
                $result = $staff_position->singleRead("staff_position",$id);
                $field = $staff_position->fieldNameValue("staff_position",$id,'id');
            }                                 
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">College Position File Maintenance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">File Maintenance</li>
                                        <li class="breadcrumb-item">College Position</li>
                                        <li class="breadcrumb-item">Edit College Position</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4"><!---start form div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Edit College Position</h3>
                                                    <h6 class="card-subtitle">تحرير المنصب</h6> 
                                                </div>
                                            </div>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $save = new DbaseManipulation;
                                                    $code = $save->cleanString($_POST['code']);
                                                    $title = $save->cleanString($_POST['title']);
                                                    $manager = $save->cleanString($_POST['manager']);

                                                    $fields = [
                                                        'code'=>$code,
                                                        'title'=>$title,
                                                        'manager'=>$manager
                                                    ];
                                                    
                                                    if($save->update("staff_position",$fields,$id)) {
                                            ?>            
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>College position has been modified and updated.</p>
                                                        </div>
                                            <?php
                                                    } 
                                                    
                                                }
                                            ?>
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">College Position Id<br>رقم المنصب</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                                                <input type="text" name="uid" value="<?php echo $field; ?>" class="form-control" required data-validation-required-message="Please type the college position Id" readonly /> 
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row --->
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Code<br>الرمز</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="code" value="<?php echo $result['code']; ?>" class="form-control" required data-validation-required-message="Please type the college position code" /> 
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row --->
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Title<br>العنوان</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="title" value="<?php echo $result['title']; ?>" class="form-control" required data-validation-required-message="Please type the college position title" /> 
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row --->
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Manager<br>المدير</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="manager" class="form-control select2" required data-validation-required-message="Please select manager from the list">
                                                                    <option value="">Select Manager Title Here</option>
                                                                    <?php 
                                                                        $managers = new DbaseManipulation;
                                                                        $rows = $managers->readData("SELECT * FROM staff_position ORDER BY id");
                                                                        foreach ($rows as $row) {
                                                                            if($result['manager'] == $row['id']) {
                                                                    ?>
                                                                                <option value="<?php echo $result['id']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['title']); ?></option>
                                                                    <?php            
                                                                            } else {
                                                                    ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['title']); ?></option>
                                                                    <?php           
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
                                                        <a href="file_position.php" class="btn btn-success waves-effect waves-light"><i class="fa fa-file"></i> Add New</a>
                                                        <!-- <a href="" class="btn btn-danger waves-effect waves-light delete-confirm" delete-id="<?php //echo $result['id']; ?>" deleting="college_position"><i class="fa fa-times"></i> Delete</a> -->
                                                    </div>
                                                </div>
                                            </form><!--end form-->
                                        </div><!--end card body-->
                                    </div><!--end card-->
                                </div><!--end col-lg-6-->
                                <!------------------------------------------------------------------------>
                                <!------------------------------------------------------------------------>

                                <div class="col-lg-8"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">College Position Names List</h4>
                                            <h6 class="card-subtitle">قائمة المناصب بالكلية</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            staff_position<th>Id</th>
                                                            <th>Code</th>
                                                            <th>Title</th>
                                                            <th>Manager</th>
                                                            <th>Active</th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("SELECT * FROM staff_position");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $row['id']; ?></td>
                                                                    <td><?php echo $row['code']; ?></td>
                                                                    <td><a href="file_position_edit.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
                                                                    <td><?php echo $row['manager']; ?></td>
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