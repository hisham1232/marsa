<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['pid']) && isset($_GET['id']) && isset($_GET['did'])) {
                $staff_position = $helper->fieldNameValue("staff_position",$_GET['pid'],'title');
                $id = $_GET['id'];
                $pid = $_GET['pid'];
                $did = $_GET['did'];
            } else {
                header("Location: settings_short_leave_sequence.php");
            }                                  
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Short Leave Approval Sequence Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Settings</li>
                                        <li class="breadcrumb-item">Short Leave Approval Sequence Details</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-18">
                                    <div class="card">
                                        <div class="card-header bg-light-info">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Short Leave Approval Sequence Form for Position <p class="font-weight-bold text-primary">[<?php echo $staff_position; ?>]</p></h3>
                                                    <h6 class="card-subtitle">استمارة تسلسل اعتماد الإجازة القصيرة</h6> 
                                                </div>
                                            </div>
                                        </div>    

                                        <div class="card-body">
                                            <?php
                                                if(isset($_POST['submitApprovalSequence'])){
                                                    $save = new DbaseManipulation;
                                                    $fields = [
                                                        'approverInSequence1'=>$_POST['approverInSequence1'],
                                                        'createdBy'=>$_POST['createdBy']
                                                    ];
                                                    if($save->update("approvalsequence_shortleave",$fields,$id)) {
                                                        $fieldsHistory = [
                                                            'position_id'=>$_POST['position_id'],
                                                            'previous_approver'=>$_POST['prev_approver'],
                                                            'new_approver'=>$_POST['approverInSequence1'],
                                                            'notes'=>$_POST['notes'],
                                                            'createdBy'=>$_POST['createdBy']
                                                        ];
                                                        $update = new DbaseManipulation;
                                                        $position_id = $_POST['position_id'];
                                                        $update->executeSQL("UPDATE approvalsequence_shortleave_history SET active = 0 WHERE position_id = $position_id");
                                                        if($save->insert("approvalsequence_shortleave_history",$fieldsHistory)){
                                                            ?>
                                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                    <p>Short leave approval has been updated.</p>
                                                                </div>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                                
                                            <form class="form-horizontal p-t-20 p-l-0 p-" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label">Approver ID</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="approver_staff_id" class="form-control approver_staff_id" readonly /> 
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label"><span class="text-danger">*</span>Position</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                                                <input type="hidden" name="prev_approver" value="<?php echo $helper->prev_approver_shortleave($id,'approverInSequence1'); ?>" />
                                                                <input type="hidden" name="department_id" value="<?php echo $did; ?>" />
                                                                <input type="hidden" name="position_id" value="<?php echo $pid; ?>" />
                                                                <select name="approverInSequence1" class="form-control select2 position_id" required data-validation-required-message="Please select college position">
                                                                    <option value="">Select College Position</option>
                                                                    <?php 
                                                                        $rows = $helper->readData("SELECT id, code, title FROM staff_position WHERE active = 1 ORDER BY id");
                                                                        foreach ($rows as $row) {
                                                                    ?>
                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                    <?php            
                                                                        }    
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label">Current Staff on This Position</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" name="approver_name" class="form-control approver_name" readonly /> 
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label"><span class="text-danger">*</span>Status</label>
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select class="form-control" required data-validation-required-message="Please select status">
                                                                    <option value="1">Active</option>
                                                                    <option value="0">Not-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label">Notes/ Comments</label>  
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <textarea class="form-control notes" name="notes" rows="2" required data-validation-required-message="Please enter comment/reason"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label">Entered By</label>                  
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" value="<?php echo $logged_name; ?>" class="form-control" readonly />
                                                                <input type="hidden" name="createdBy" value="<?php echo $staffId; ?>" class="form-control" readonly> 
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-lg-3 control-label">Entered Date</label>                  
                                                    <div class="col-lg-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo date('d/m/Y H:i:s'); ?>" class="form-control" readonly>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><span class="far fa-calendar-alt"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-lg-9">
                                                        <button type="submit" name="submitApprovalSequence" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>                                            
                                        </div>
                                    </div><!--end card-->
                                </div><!--end col-lg-4-->
                                <!------------------------------------------------------------------------>
                                <!------------------------------------------------------------------------>
                                <div class="col-lg-8 col-sm-18"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-header bg-light-info">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h4 class="card-title">Approver for Position [<span class="font-weight-bold text-primary"><?php echo $staff_position; ?></span>]</h4>
                                                    <h6 class="card-subtitle">معتمِد المنصب</h6>
                                                </div>
                                            </div>
                                            
                                        </div>
                                          
                                        <div class="card-body">
                                            <div>
                                                <button class="btn btn-sm btn-primary viewHistory"><i class="fa fa-search"></i> View Approver Changes/Updates History</button>
                                                <input type="hidden" value="<?php echo $pid; ?>" class="g_position_id" />
                                            </div>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Sequence</th>
                                                            <th>Approver Position</th>
                                                            <th>Approver Name</th>
                                                            <th>Status</th>
                                                            <th>Entered By</th>
                                                            <th>Entered Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            //Listing only the first approval since this is a short leave.
                                                            $row = $helper->singleReadFullQry("SELECT a.id, a.approverInSequence1, concat(es.firstName,' ',es.secondName,' ',es.thirdName,' ',es.lastName) as approverName, as1.title as sequence1, as2.title as sequence2, a.active, a.createdBy, a.created, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as createdBy 
                                                            FROM approvalsequence_shortleave as a 
                                                            LEFT OUTER JOIN department as d ON d.id = a.department_id 
                                                            LEFT OUTER JOIN staff_position as p ON p.id = a.position_id 
                                                            LEFT OUTER JOIN staff_position as as1 ON as1.id = a.approverInSequence1 
                                                            LEFT OUTER JOIN staff_position as as2 ON as2.id = a.approverInSequence2 
                                                            LEFT OUTER JOIN staff as s ON s.staffId = a.createdBy 
                                                            LEFT OUTER JOIN employmentdetail as e ON e.position_id = a.approverInSequence1
                                                            LEFT OUTER JOIN staff as es ON es.staffId = e.staff_id
                                                            WHERE a.id = $id");
                                                            if($helper->totalCount != 0) {
                                                            ?>
                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td><?php echo $row['sequence1']; ?></td>
                                                                    <td><span class=""><?php echo $row['approverName']; ?></span></td>
                                                                    <td><?php echo $row['active'] ? "<span class='badge badge-success'>Active</span>" : "<span class='badge badge-danger'>Not Active</span>"; ?></td>
                                                                    <td><?php echo $row['createdBy']; ?></td>
                                                                    <td><?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?></td>
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
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>                
                <?php include('include_scripts.php'); ?>
                <script>
                    $('.viewHistory').click(function(){
                        var position_id = $('.g_position_id').val();
                        var data = {
                            position_id : position_id
                        }
                        $.ajax({
                            url	 : 'ajaxpages/leaves/settings/shortleave_history.php'
                            ,type	 : 'POST'
                            ,dataType: 'json'
                            ,data	 : data
                            ,success : function(e){
                                if(e.error == 1){
                                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                } else {
                                    bootbox.alert({
                                        title: "<span class='text-primary'><i class='fa fa-info-circle'></i> Information</span>", 
                                        message: e.message,
                                        size: 'large'
                                    });
                                }	
                            }
                            ,error	: function(e){
                            }
                        });
                    });
                    $(".position_id").change(function() {
                        var position_id = $('.position_id').val();
                        var data = {
                            position_id : position_id
                        }
                        $.ajax({
                            url	 : 'ajaxpages/leaves/settings/queryapproverinfo.php'
                            ,type	 : 'POST'
                            ,dataType: 'json'
                            ,data	 : data
                            ,success : function(e){
                                if(e.error == 1){
                                    bootbox.alert(e.message);
                                } else {
                                    $('.approver_staff_id').val(e.staff_id);
                                    $('.approver_name').val(e.staff_name);
                                    $('.notes').focus();
                                }	
                            }
                            ,error	: function(e){
                            }
                        });
                    });    
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>