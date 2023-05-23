<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $added = new DbaseManipulation;                        
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">All MINUS Emergency Leave Balance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Emergency Balance</a></li>
                                        <li class="breadcrumb-item">All MINUS Emergency </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">List of All MINUS (Transaction) Emergency Balance</h4>
                                            <h6 class="card-subtitle">قائمة بكل عمليات خصم رصيد الإجازات الطارئة</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>    
                                                            <th>Process Date</th>
                                                            <th>Transaction ID</th>
                                                            <th>Staff ID</th>
                                                            <th>Staff Name</th>
                                                            <th>Department</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Total</th>
                                                            <th>Processed By</th>
                                                            <th>Note</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $dept = new DbaseManipulation;
                                                            $rows = $added->readData("SELECT i.created, i.emergencyleavebalance_id, i.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, i.startDate, i.endDate, i.total, i.notes, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as addedBy FROM emergencyleavebalancedetails as i 
                                                            LEFT OUTER JOIN staff as s ON s.staffId = i.staffId
                                                            LEFT OUTER JOIN staff as ss ON ss.staffId = i.createdBy
                                                            WHERE i.status != 'Saved'
                                                            ORDER BY i.created DESC");
                                                            if($added->totalCount != 0) {
                                                                $i = 0;
                                                                foreach($rows as $row){
                                                                    $department_id = $dept->employmentIDs($row['staffId'],'department_id');
                                                        ?>
                                                                    <tr>
                                                                        <td><?php echo ++$i."."; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['created'])); ?></td>
                                                                        <?php
                                                                            if (strpos($row['emergencyleavebalance_id'], 'SYS-') !== false) {
                                                                                ?>
                                                                                    <td><a href="javascript:void(0)"><?php echo $row['emergencyleavebalance_id']; ?></a></td>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                    <td><a href="standardleave_details.php?id=<?php echo $row['emergencyleavebalance_id']; ?>&uid=<?php echo $row['staffId']; ?>"><?php echo $row['emergencyleavebalance_id']; ?></a></td>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        
                                                                        <td><?php echo $row['staffId']; ?></td>
                                                                        <td><?php echo $row['staffName']; ?></td>
                                                                        <td><?php echo $dept->fieldNameValue('department',$department_id,'name'); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                        <td><?php echo $row['total']; ?></td>
                                                                        <td><?php echo $row['addedBy']; ?></td>
                                                                        <td><?php echo $row['notes']; ?></td>
                                                                    </tr>
                                                        <?php
                                                                }
                                                                $i++;
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