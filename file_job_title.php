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
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Job Title File Maintenance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">File Maintenance</li>
                                        <li class="breadcrumb-item">Job Title</li>
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
                                                    <h3 class="card-title">Add New Job Title</h3>
                                                    <h6 class="card-subtitle">أضف مسمى وظيفي</h6> 
                                                </div>
                                            </div>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $save = new DbaseManipulation;
                                                    $name = $save->cleanString($_POST['name']);

                                                    $fields = [
                                                        'name'=>$name
                                                    ];
                                                    
                                                    if($save->insert("jobtitle",$fields)) {
                                            ?>            
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>New job title has been added and saved.</p>
                                                        </div>
                                            <?php
                                                    } 
                                                    
                                                }
                                            ?>
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Name<br>الاسم</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="name" class="form-control" required data-validation-required-message="Please type the job title name" /> 
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-9-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Open modal</button>-->
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
                                            <h4 class="card-title">Job Title Names List</h4>
                                            <h6 class="card-subtitle">قائمة بالمسميات الوظيفية</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Job Title</th>
                                                            <th>Active</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("SELECT * FROM jobtitle");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $row['id']; ?></td>
                                                                    <td><a href="file_job_title_edit.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
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