<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $staffId == '119084' || $staffId == '121101' || $staffId == '189010') ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $logged_in_department_name = $helper->fieldNameValue("department",$logged_in_department_id,'name');                            
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
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Winner Statistics - By Department</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Awarding </li>
                                        <li class="breadcrumb-item">Winner Statistics</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-18 col-xs-18">
                                    <div class="card card-body p-b-0 bg-light-success">
                                        <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-md-1 col-form-label">Year</label>
                                                <div class="col-md-1">
                                                    <div class="controls">
                                                        <select class="form-control" name="selectYear">
                                                            <option value="">Select</option>
                                                            <option>2020</option>
                                                            <option>2021</option>
                                                            <option>2022</option>
                                                            <option>2023</option>
                                                            <option>2025</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-success waves-effect waves-light" name="btnSearch" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <?php 
                                            if(isset($_POST['btnSearch'])) {
                                                $currentYear = $_POST['selectYear'];
                                            } else {
                                                $currentYear = date('Y');
                                            }
                                        ?>
                                        <div class="card-header bg-light-success2" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Winner Statistics for [<span class="text-primary"><?php echo $currentYear; ?></span>]</h4>
                                        </div>
                                        <div class="card-body bg-light-success">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Department</th>
                                                            <th>Jan</th>
                                                            <th>Feb</th>
                                                            <th>Mar</th>
                                                            <th>Apr</th>
                                                            <th>May</th>
                                                            <th>Jun</th>
                                                            <th>Jul</th>
                                                            <th>Aug</th>
                                                            <th>Sep</th>
                                                            <th>Oct</th>
                                                            <th>Nov</th>
                                                            <th>Dec</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $load = new DbaseManipulation;
                                                            $rows = $load->readData("SELECT id, name as department, isAcademic FROM department");
                                                            if($load->totalCount != 0) {
                                                                $i = 0;
                                                                $total = 0;
                                                                
                                                                $statistic = new DbaseManipulation;
                                                                foreach ($rows as $row) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                        <td><?php echo $row['department']; ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'January','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'February','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'March','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'April','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'May','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'June','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'July','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'August','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'September','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'October','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'November','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'December','winnerCtr'); ?></td>
                                                                        <td><?php echo $statistic->countDepartmentWinner($row['id'],$currentYear,'January','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'February','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'March','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'April','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'May','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'June','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'July','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'August','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'September','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'October','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'November','winnerCtr') + $statistic->countDepartmentWinner($row['id'],$currentYear,'December','winnerCtr'); ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                        </div><!--end card body-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-6-->
                            </div>
                        </div>            
                        <footer class="footer">
                            <?php
                                include('include_footer.php'); 
                            ?>
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