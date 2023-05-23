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
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Short Leave Approval Sequence</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Leave Settings</li>
                                        <li class="breadcrumb-item">Short Leave Approval Sequence<</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                    <div class="card-header bg-light-info m-b-0 p-b-0">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Short Leave Approval Sequence by College Position</h3>                    
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
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table data-toggle="table"  data-mobile-responsive="true" class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Position</th>
                                                                                            <th>Approval Sequence 1</th>
                                                                                            <th>Informed To</th>
                                                                                            <th>Action</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                            $SeqRows = $sequenceList->readData("SELECT a.id, a.department_id, d.name as department, a.position_id, p.title as position, as1.title as sequence1, as2.title as sequence2 FROM approvalsequence_shortleave as a LEFT OUTER JOIN department as d ON d.id = a.department_id LEFT OUTER JOIN staff_position as p ON p.id = a.position_id LEFT OUTER JOIN staff_position as as1 ON as1.id = a.approverInSequence1 LEFT OUTER JOIN staff_position as as2 ON as2.id = a.approverInSequence2 WHERE a.department_id = $department_id ORDER BY a.chronological");
                                                                                            if($sequenceList->totalCount != 0) {
                                                                                                foreach($SeqRows as $seqRow){
                                                                                        ?>            
                                                                                                    <tr id="tr-id-<?php echo $seqRow['id']; ?>">
                                                                                                        <td><?php echo $seqRow['position']; ?></td>
                                                                                                        <td><?php echo $seqRow['sequence1']; ?></td>
                                                                                                        <td><?php echo $seqRow['sequence2']; ?></td>
                                                                                                        <td><a href="settings_short_leave_sequence_details.php?id=<?php echo $seqRow['id']; ?>&pid=<?php echo $seqRow['position_id']; ?>&did=<?php echo $seqRow['department_id']; ?>" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Approval Sequence"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                                                                                    </tr>
                                                                                        <?php    
                                                                                                }
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
                                    </div><!--end card-->            
                                </div><!--end col-lg-10-->
                            </div><!--end row-->
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