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
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Standard Leave Approval Sequence</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Leave Settings</li>
                                        <li class="breadcrumb-item">Standard Leave Approval Sequence<</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0 p-b-0">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Standard Leave Approval Sequence by College Position</h3>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="card-body">
                                            <!-- Accordion style -->
                                            <div id="accordion-style-1">
                                                <div class="accordion" id="accordionShortLeaveSequence">
                                                    <?php
                                                        $departments = new DbaseManipulation;
                                                        $rows = $departments->readData("SELECT id as department_id, name as departmentName, shortName FROM department WHERE active = 1");
                                                        if($departments->totalCount != 0) {
                                                            $sequenceList = new DbaseManipulation;
                                                            foreach($rows as $row){
                                                                $department_id = $row['department_id'];
                                                                ?>    
                                                                <div class="card">
                                                                    <div class="card-header" id="headingOne">
                                                                        <div class="d-flex no-block align-items-center">
                                                                            <h4 class="card-title">
                                                                                <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#departmentId<?php echo $row['department_id']; ?>" aria-expanded="true" aria-controls="collapseTwo">
                                                                                <i class="fa as fa-key main"></i><i class="fa fa-angle-double-right mr-3"></i><?php echo $row['departmentName']." (".$row['shortName'].")"; ?>
                                                                                </button>
                                                                            </h4>
                                                                        </div><!--end d-flex -->
                                                                    </div><!--end card-header-->
                                                                    <div id="departmentId<?php echo $row['department_id']; ?>" class="collapse fade" aria-labelledby="headingOne" data-parent="#accordionShortLeaveSequence">
                                                                        <a href="settings_standard_leave_sequence_details_add.php?did=<?php echo $row['department_id']; ?>" class="btn  btn-primary waves-effect waves-light" role="button" title="Click to view/edit Approval Sequence"><span class="text-white"><i class="fa fa-paper-plane"></i> Add New</span></a>
                                                                        <br>
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table data-toggle="table"  data-mobile-responsive="true" class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="font-weight: bold">Position</th>
                                                                                            <th style="font-weight: bold">Sequence 1</th>
                                                                                            <th style="font-weight: bold">Sequence 2</th>
                                                                                            <th style="font-weight: bold">Sequence 3</th>
                                                                                            <th style="font-weight: bold">Sequence 4</th>
                                                                                            <!-- <th style="font-weight: bold">Sequence 5</th> -->
                                                                                            <th style="font-weight: bold">Action</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                            $distinct_position_id = new DbaseManipulation;
                                                                                            $pos = $distinct_position_id->readData("SELECT DISTINCT p.position_id, sp.title FROM approvalsequence_standardleave_5 as p LEFT OUTER JOIN staff_position as sp ON sp.id = p.position_id WHERE p.department_id = $department_id ORDER BY p.position_id");
                                                                                            if($distinct_position_id->totalCount != 0) {
                                                                                                foreach($pos as $p) {
                                                                                                    $posi_id = $p['position_id'];
                                                                                                    $position_title = $p['title'];
                                                                                                        $SeqRows = $sequenceList->readData("SELECT a.*, d.name as department, p.title as position, ap.title as approverTitle
                                                                                                                    FROM approvalsequence_standardleave_5 as a 
                                                                                                                    LEFT OUTER JOIN department as d ON d.id = a.department_id 
                                                                                                                    LEFT OUTER JOIN staff_position as p ON p.id = a.position_id
                                                                                                                    LEFT OUTER JOIN staff_position as ap ON ap.id = a.approver_id
                                                                                                                    WHERE a.department_id = $department_id AND a.position_id = $posi_id AND a.active = 1 ORDER BY a.sequence_no");
                                                                                                        echo "<tr>
                                                                                                                <td>".$position_title."</td>";    
                                                                                                                foreach($SeqRows as $rows){
                                                                                                                    ?>            
                                                                                                                    <td><?php echo $rows['approverTitle']; ?></td>
                                                                                                                    <?php    
                                                                                                                }
                                                                                                                if ($sequenceList->totalCount == 1) {
                                                                                                                    echo "<td></td>><td></td><td></td>";
                                                                                                                } else if($sequenceList->totalCount == 2) {
                                                                                                                    echo "<td></td>><td></td>";
                                                                                                                } else if ($sequenceList->totalCount == 3) {
                                                                                                                    echo "<td></td>";
                                                                                                                } else if ($sequenceList->totalCount == 4) {
                                                                                                                    echo "";
                                                                                                                }    
                                                                                                                ?>
                                                                                                                    <td><a href="settings_standard_leave_sequence_details.php?pid=<?php echo $posi_id; ?>&did=<?php echo $row['department_id']; ?>" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Approval Sequence"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                                                                                                <?php                                                                                                            
                                                                                                        echo "</tr>";
                                                                                                }        
                                                                                            } else {
                                                                                                //echo $row['department_id'];
                                                                                                ?>
                                                                                                <!-- There is no position id yet in here -->
                                                                                                <a href="settings_standard_leave_sequence_details_add.php?did=<?php echo $row['department_id']; ?>" class="btn  btn-primary waves-effect waves-light" role="button" title="Click to view/edit Approval Sequence"><span class="text-white"><i class="fa fa-paper-plane"></i> Add New</span></a>
                                                                                                <?php
                                                                                            }   
                                                                                        ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div><!--end table responsive-->
                                                                        </div><!--end card body for table-->
                                                                    </div><!--end collapseOne id-->
                                                                </div><!--end card for one entry-->
                                                                <?php
                                                            }
                                                        }
                                                    ?>    
                                                </div><!--end for accordion whole-->    
                                            </div><!--end for accordion style-1-->                                   
                                        </div><!--end card body for all-->    
                                    </div>
                                </div><!--end col-lg-12-->
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