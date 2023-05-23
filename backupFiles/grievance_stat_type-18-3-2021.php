<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $staffId == '119084' || $staffId == '121101' || $staffId == '107036') ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
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
                     <?php    include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Grievance Statistics - By Type</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Grievance  </li>
                                        <li class="breadcrumb-item">Grievance Statistics - By Type</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <!------------------------------------------------->
                            <div class="row">
                                <div class="col-lg-12 col-md-18 col-xs-18">
                                    <div class="card card-body p-b-0 bg-light-warning">
                                        <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row m-b-5 m-t-0">
                                                <label class="col-md-1 col-form-label">Date</label>
                                                <div class="col-md-3">
                                                    <div class="controls">
                                                        <input type='text' class="form-control daterange"/>
                                                        <input type="hidden" name="startDate" class="form-control startDate" />
                                                        <input type="hidden" name="endDate" class="form-control endDate" />
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-1 ">
                                                    <button class="btn btn-success waves-effect waves-light" name="submit" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------------->
                            <div class="row"><!--for result-->
                                <div class="col-lg-12 col-md-18 col-xs-18"><!---start for list div-->
                                    <div class="card bg-light-warning2">
                                        <div class="card-header bg-light-warning2" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Grievance Statistics - By Type</h4>
                                        </div><!--end card header-->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Department</th>
                                                            <th>Academic</th>
                                                            <th>Administrative</th>
                                                            <th>Personal</th>
                                                            <th>Other</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['submit'])) {
                                                                $startDate =  $_POST['startDate'].' 00:00:00';
                                                                $endDate =  $_POST['endDate'].' 23:59:59';
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
                                                                            <td><?php echo $statistic->countGrievanceDate($row['id'],1,$startDate,$endDate,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievanceDate($row['id'],2,$startDate,$endDate,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievanceDate($row['id'],3,$startDate,$endDate,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievanceDate($row['id'],4,$startDate,$endDate,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievanceTotalDate($row['id'],$startDate,$endDate,'statCountTotal'); ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
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
                                                                            <td><?php echo $statistic->countGrievance($row['id'],1,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievance($row['id'],2,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievance($row['id'],3,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievance($row['id'],4,'statCount'); ?></td>
                                                                            <td><?php echo $statistic->countGrievanceTotal($row['id'],'statCountTotal'); ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
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
                <script>
                    // MAterial Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });
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