<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        $dropdown = new DbaseManipulation;
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Search Staff Short Leave</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Short Leave</li>
                                        <li class="breadcrumb-item active">Search Staff Short Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <h4 class="card-title">Search Short Leave Form</h4>
                                            <h6>إستمارة البحث عن الإجازات القصيرة</h6>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" action="" method="POST" novalidate
                                                enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Staff ID</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="staffId" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="firstName" class="form-control" data-validation-required-message="Please enter first name" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sponsor_id" class="form-control">
                                                                            <option value="0">Select Sponsor</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM sponsor ORDER BY id");
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
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="department_id" class="form-control" required data-validation-required-message="Please select department">
                                                                            <option value="0">Select Department</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM department ORDER BY id");
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
                                                            <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="section_id" class="form-control">
                                                                            <option value="0">Select Section</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM section ORDER BY id");
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
                                                            <label class="col-sm-4 text-right control-label col-form-label">College Position</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="position_id" class="form-control">
                                                                            <option value="0">Select College Position</option>
                                                                            <option value="1">College Position 1</option>
                                                                            <option value="2">College Position 2</option>
                                                                        </select>
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
                                                                    <input type='text' class="form-control daterange" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <span class="far fa-calendar-alt"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Staus</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sponsor_id" class="form-control">
                                                                            <option value="0">Select Status</option>
                                                                            <option value="1">Status 1</option>
                                                                            <option value="2">Status 2</option>
                                                                            <option value="3">Status 3</option>
                                                                        </select>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-b-0">
                                                            <div class="offset-sm-4 col-sm-8">
                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                    
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <h4 class="card-title">Search Result</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Staff ID</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Sponsor</th>
                                                            <th>Requested Date</th>
                                                            <th>Leave Date</th>
                                                            <th>Start Time</th>
                                                            <th>Return Time</th>
                                                            <th>No. of Hours</th>
                                                            <th>Last Update</th>
                                                            <th>Last Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href="shortleave_application.php">OLT-1019828</a></td>
                                                            <td><a href="shortleave_application.php">12345678</a></td>
                                                            <td>Staff Name Here</td>
                                                            <td>Information Technology</td>
                                                            <td>Math Section</td>
                                                            <td>TATI</td>
                                                            <td>21/10/2018</td>
                                                            <td>22/10/2018</td>
                                                            <td>09:40am</td>
                                                            <td>01:40pm</td>
                                                            <td>3</td>
                                                            <td>24/10/18 10:58:46</td>
                                                            <td>For Approval - HoS - Educational Services Section</td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="shortleave_application.php.php">OLT-1019828</a></td>
                                                            <td><a href="shortleave_application.php">123456</td>
                                                            <td>Staff Name Here</td>
                                                            <td>Business Department</td>
                                                            <td>Human Resource Section</td>
                                                            <td>Al-Nawa</td>
                                                            <td>21/10/2018</td>
                                                            <td>22/10/2018</td>
                                                            <td>09:40am</td>
                                                            <td>01:40pm</td>
                                                            <td>3</td>
                                                            <td>24/10/18 10:58:46</td>
                                                            <td>Rejected - HoS - Applied Science</td>
                                                        </tr>
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

                <script>
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