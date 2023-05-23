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
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                     <?php    include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Statistics</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">Statistics</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <!------------------------------------------------->
                            <div class="row">
                                <div class="col-lg-12 col-md-18 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-md-1 col-form-label">Date</label>
                                                <div class="col-md-3">
                                                    <div class="controls">
                                                        <input type='text' class="form-control daterange" required data-validation-required-message="Please select date"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-success waves-effect waves-light"  type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">By - Application Type - Clearance Statistics for [<span class="text-primary"><?php echo date('d/m/Y').' to '.date('d/m/Y') ?></span>]</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Department</th>
                                                            <th>Standard Clearance</th>
                                                            <th>Short-Term Clearance</th>
                                                            <th>No-Application</th>
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
                                                                        <td><?php echo $helper->countStandardClearance($row['id'],'ctr') ?></td>
                                                                        <td><?php echo $helper->countShortClearance($row['id'],'ctr') ?></td>
                                                                        <td><?php echo $helper->countSkipClearance($row['id'],'ctr') ?></td>
                                                                        <td>
                                                                            <?php 
                                                                                $total = $helper->countStandardClearance($row['id'],'ctr') + $helper->countShortClearance($row['id'],'ctr');
                                                                                echo $total;
                                                                                $total = 0;
                                                                            ?>
                                                                        </td>
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

                            <hr>

                            <div class="row"><!--for result-->
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">By Status - Clearance Statistics for [<span class="text-primary">Date to Date</span>]</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Department</th>
                                                            <th>Resigned</th>
                                                            <th>Transferred</th>
                                                            <th>Terminated</th>
                                                            <th>On Study</th>
                                                            <th>On Leave</th>
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
                                                                        <td><?php echo $helper->countClearanceByStatus($row['id'],5,'ctr') ?></td>
                                                                        <td><?php echo $helper->countClearanceByStatus($row['id'],4,'ctr') ?></td>
                                                                        <td><?php echo $helper->countClearanceByStatus($row['id'],6,'ctr') ?></td>
                                                                        <td><?php echo $helper->countClearanceByStatus($row['id'],3,'ctr') ?></td>
                                                                        <td><?php echo $helper->countClearanceByStatus($row['id'],2,'ctr') ?></td>
                                                                        <td>
                                                                            <?php 
                                                                                $total2 = $helper->countClearanceByStatus($row['id'],5,'ctr') + $helper->countClearanceByStatus($row['id'],4,'ctr') + $helper->countClearanceByStatus($row['id'],6,'ctr') + $helper->countClearanceByStatus($row['id'],3,'ctr') + $helper->countClearanceByStatus($row['id'],2,'ctr');
                                                                                echo $total2;
                                                                                $total2 = 0;
                                                                            ?>
                                                                        </td>
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