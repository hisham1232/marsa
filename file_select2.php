<?php    
    include('include_headers.php');                                 
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
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>September 24,2018</small></h6>
                                    <h6 class="m-b-0"><small>Your Time-In Today</small></h6>
                                    <h4 class="m-t-0 text-primary">08:00am</h4>
                                </div>
                                <div class="spark-chart">
                                    <i class="far fa-clock fa-3x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6"><!---start form div-->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h3 class="card-title">Add New Department</h3>
                                        <h6 class="card-subtitle">اضافة قسم جديد</h6> 
                                    </div>
                                </div>
                                <?php 
                                    if(isset($_POST['submit'])) {
                                        $deptsIds = array();
                                        foreach ($_POST['sDepartment'] as $selectedOption2) {
                                            array_push($deptsIds,$selectedOption2);
                                        }
                                        $deptList = implode(', ', $deptsIds); //for your SQL Statement you need to use IN ($deptList)
                                        
                                    }
                                ?>
                                <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Name<br>تاريخ الطلب</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" name="name" class="form-control" required data-validation-required-message="Please type the department name" /> 
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Short Name<br>تاريخ الطلب</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" name="shortName" class="form-control" required data-validation-required-message="Please type the department's short name" />
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Manager<br>تاريخ الطلب</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="managerId" class="form-control" required data-validation-required-message="Please select manager from the list">
                                                        <option value="">Select Manager Here</option>
                                                        <option value="1">Manager 1</option>
                                                        <option value="2">Manager 2</option>
                                                        <option value="3">Manager 3</option>
                                                        <?php 
                                                            $managers = new DbaseManipulation;
                                                            $rows = $managers->readData("SELECT id, firstName, secondName, thirdName, lastName FROM staff WHERE status_id = 1");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $managers->getStaffName($row['id'],$row['firstName'],$row['secondName'],$row['thirdName'],$row['lastName']); ?></option>
                                                        <?php            
                                                            }    
                                                        ?>
                                                    </select>
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Is Academic?<br>تاريخ الطلب</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="isAcademic" class="form-control" required data-validation-required-message="Please select either YES or NO from this list">
                                                        <option value="">Select Value Here</option>
                                                        <option value="1">YES</option>
                                                        <option value="0">NO</option>
                                                    </select>
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->


                                     <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span> Select Many </label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <!--<select id="multiple" name="sDepartment[]" class="form-control select2-multiple" multiple="multiple">
                                                    
                                                    Use this php code after submitting the form
                                                    $deptsIds = array();
                                                    foreach ($_POST['sDepartment'] as $selectedOption2) {
                                                        array_push($deptsIds,$selectedOption2);
                                                    }
                                                    $deptList = implode(', ', $deptsIds); //for your SQL Statement you need to use IN ($deptList)
                                                    die($deptList);
                                                        
                                                    -->
                                                    <select name="sDepartment" class="select2 form-control m-b-10" multiple data-placeholder="Choose">
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                    </select>
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
                                <h4 class="card-title">Department Names List</h4>
                                <h6 class="card-subtitle">قائمة الأقسام</h6>
                                <div class="table-responsive">
                                    <table id="example23" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Department Name</th>
                                                <th>Short Name</th>
                                                <th>Manager</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $data = new DbaseManipulation;
                                                $rows = $data->readData("SELECT * FROM department");
                                                foreach ($rows as $row) {
                                            ?>
                                                    <tr style="text-align: center">
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><a href="file_department_edit.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                                                        <td><?php echo $row['shortName']; ?></td>
                                                        <td><?php echo $row['managerId']; ?></td>
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
</html>