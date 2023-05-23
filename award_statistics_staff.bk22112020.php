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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Winner Statistics - By Staff</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Awarding </li>
                                        <li class="breadcrumb-item">Winner Statistics</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header bg-light-success2" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Winner Statistics - By Staff</h4>
                                        </div>
                                        <div class="card-body bg-light-success">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Number of Times Wins</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $load = new DbaseManipulation;
                                                            $info = new DbaseManipulation;
                                                            $rows = $load->readData("SELECT DISTINCT(staffId) FROM award_candidate WHERE canStatus = 'Winner'");
                                                            if($load->totalCount != 0) {
                                                                $i = 0;
                                                                foreach ($rows as $row) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                        <td><a href="award_winner_list.php" title="Click to view winning months"><?php echo $info->getStaffName($row['staffId'],'firstName','secondName','thirdName','lastName') ?></a></td>
                                                                        <td><?php echo $info->countWinnings($row['staffId'],'winningCtr'); ?></td>
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
                            <?php include('include_footer.php'); ?>
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