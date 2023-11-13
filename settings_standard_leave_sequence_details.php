<?php    
    include('include_headers.php');  
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['pid']) && isset($_GET['did'])) {
                $staff_position = $helper->fieldNameValue("staff_position",$_GET['pid'],'title');
                $pid = $_GET['pid'];
                $did = $_GET['did'];
            } else {
                header("Location: settings_standard_leave_sequence.php");
            }                                  
?>

<body class="fix-header fix-sidebar card-no-border">
    <style type="text/css">
    .modal-body {
        /*For History Modal, using bootbox.alert*/
        height: 500px;
        overflow-y: scroll;
    }
    </style>
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Standard Leave Approval Sequence Details</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item">Standard Leave Approval Sequence Details</li>
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
                                        <h3 class="card-title">Standard Leave Approval Sequence Form for Position <p
                                                class="font-weight-bold text-primary">[<?php echo $staff_position; ?>]
                                            </p>
                                        </h3>
                                        <h6 class="card-subtitle">استمارة تسلسل إعتماد الإجازة</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?php
                                                if(isset($_POST['submitApprovalSequence'])){
                                                    $save = new DbaseManipulation;
                                                    $info = new DbaseManipulation;
                                                    $upd  = new DbaseManipulation;
                                                    $department_id = $_POST['department_id'];
                                                    $position_id = $_POST['position_id'];
                                                    //$last = $info->singleReadFullQry("SELECT TOP 1 sequence_no FROM approvalsequence_standardleave WHERE department_id = $department_id AND position_id = $position_id ORDER BY sequence_no DESC");
                                                    //$new_sequence_no = $last['sequence_no'] + 1;
                                                    $sequenceNo = $_POST['sequenceNo'];
                                                    $fields = [
                                                        'department_id'=>$department_id,
                                                        'position_id'=>$position_id,
                                                        'approver_id'=>$_POST['approver_id'],
                                                        'sequence_no'=>$sequenceNo,
                                                        'active'=>$_POST['statActive'],
                                                        'created_by'=>$_POST['createdBy']
                                                    ];
                                                    $upd->executeSQL("UPDATE approvalsequence_standardleave SET active = 0 WHERE sequence_no = $sequenceNo AND position_id = $position_id AND department_id = $department_id");
                                                    if($save->insert("approvalsequence_standardleave",$fields)){
                                                        $fieldsHistory = [
                                                            'position_id'=>$position_id,
                                                            'previous_approver'=>$_POST['approver_id'],
                                                            'new_approver'=>$_POST['approver_id'],
                                                            'sequence_no'=>$sequenceNo,
                                                            'active'=>$_POST['statActive'],
                                                            'notes'=>$_POST['notes'],
                                                            'createdBy'=>$_POST['createdBy']
                                                        ];
                                                        if($save->insert("approvalsequence_standard_history",$fieldsHistory)){
                                                            ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                    <p>New leave approval sequence has been added and submitted.</p>
                                </div>
                                <?php
                                                        }    
                                                    }
                                                }
                                                if(isset($_POST['updateApprovalSequence'])) {
                                                    $save = new DbaseManipulation;
                                                    $seqUpdater = new DbaseManipulation;
                                                    $id = $_POST['id'];
                                                    $new_approver = $_POST['approver_id'];
                                                    $fields = [
                                                        'approver_id'=>$new_approver,
                                                        'active'=>$_POST['statActive'],
                                                        'is_final'=>$_POST['isFinal'],
                                                    ];
                                                    if($save->update("approvalsequence_standardleave",$fields,$id)) {
                                                        $update = new DbaseManipulation;
                                                        $position_id = $_POST['position_id'];
                                                        $sequence_no = $_POST['sequence_no'];
                                                        $active = $_POST['statActive'];
                                                        $update->executeSQL("UPDATE approvalsequence_standard_history SET active = 0 WHERE position_id = $position_id AND sequence_no = $sequence_no");
                                                        $fieldsHistory = [
                                                            'position_id'=>$_POST['position_id'],
                                                            'previous_approver'=>$_POST['previous_approver'],
                                                            'new_approver'=>$_POST['approver_id'],
                                                            'sequence_no'=>$_POST['sequence_no'],
                                                            'active'=>$_POST['statActive'],
                                                            'notes'=>$_POST['notes'],
                                                            'createdBy'=>$_POST['createdBy']
                                                        ];
                                                        
                                                        if($save->insert("approvalsequence_standard_history",$fieldsHistory)) {
                                                            //Fixing sequence_no if there would be a broken order in sequence_no once field name active was change...
                                                            $rows = $helper->readData("SELECT * FROM approvalsequence_standardleave WHERE position_id = $position_id AND active = 1 ORDER BY sequence_no");
                                                            if($helper->totalCount != 0) {
                                                                $i = 1;
                                                                foreach($rows as $row){
                                                                    $id = $row['id'];
                                                                    $seqUpdater->executeSQL("UPDATE approvalsequence_standardleave SET sequence_no = $i WHERE id = $id");
                                                                    $i++;
                                                                }
                                                            }
                                                            ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                    <p>Standard leave approval has been edited and updated.</p>
                                </div>
                                <?php
                                                        }
                                                    }
                                                }
                                            ?>

                                <form class="form-horizontal p-t-20 p-l-0 p-" action="" method="POST" novalidate
                                    enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label">Approver ID</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" name="approver_staff_id"
                                                        class="form-control approver_staff_id" readonly />
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
                                        <label class="col-lg-3 control-label"><span
                                                class="text-danger">*</span>Position</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="hidden" name="id" class="id" />
                                                    <input type="hidden" name="sequence_no" class="sequence_no" />
                                                    <input type="hidden" name="previous_approver"
                                                        class="previous_approver" />
                                                    <input type="hidden" name="department_id"
                                                        value="<?php echo $did; ?>" />
                                                    <input type="hidden" name="position_id"
                                                        value="<?php echo $pid; ?>" />
                                                    <select name="approver_id" class="form-control select2 position_id"
                                                        required
                                                        data-validation-required-message="Please select college position">
                                                        <option value="">Select College Position</option>
                                                        <?php 
                                                                        $rows = $helper->readData("SELECT id, code, title FROM staff_position WHERE active = 1 ORDER BY id");
                                                                        foreach ($rows as $row) {
                                                                    ?>
                                                        <option value="<?php echo $row['id']; ?>">
                                                            <?php echo $row['title']; ?></option>
                                                        <?php            
                                                                        }    
                                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label">Current Staff on This Position</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" name="approver_name"
                                                        class="form-control approver_name" readonly />
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="fas fa-user"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label"><span
                                                class="text-danger">*</span>Status</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="statActive" class="form-control statActive" required
                                                        data-validation-required-message="Please select status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Not-Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label"><span class="text-danger">*</span>Is Final
                                            Approver</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="isFinal" id='is_final1' class="form-control is_final">
                                                        <option value="1">YES</option>
                                                        <option value="0">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label"><span
                                                class="text-danger">*</span>Sequence</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="sequenceNo" class="form-control sequence_No" required
                                                        data-validation-required-message="Please select sequence">
                                                        <option value="">Select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label">Notes/ Comments</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <textarea class="form-control notes" name="notes" rows="2" required
                                                        data-validation-required-message="Please enter comment/reason"></textarea>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="far fa-comment"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label">Entered By</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $logged_name; ?>"
                                                        class="form-control" readonly />
                                                    <input type="hidden" name="createdBy"
                                                        value="<?php echo $staffId; ?>" class="form-control" readonly>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="fas fa-user"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label">Entered Date</label>
                                        <div class="col-lg-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo date('d/m/Y H:i:s'); ?>"
                                                        class="form-control" readonly>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><span
                                                                class="far fa-calendar-alt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row m-b-0">
                                        <div class="offset-sm-3 col-lg-9">
                                            <button type="submit" name="submitApprovalSequence"
                                                class="btn btn-info waves-effect waves-light submitApprovalSequence"><i
                                                    class="fa fa-paper-plane"></i> Submit</button>
                                            <button type="submit" name="updateApprovalSequence"
                                                class="btn btn-info waves-effect waves-light updateApprovalSequence"
                                                style='display:none'><i class="fa fa-paper-plane"></i> Update</button>
                                            <a href="" class="btn btn-inverse waves-effect waves-light"><i
                                                    class="fa fa-retweet"></i> Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-lg-4-->
                    <!------------------------------------------------------------------------>
                    <!------------------------------------------------------------------------>
                    <div class="col-lg-8 col-sm-18">
                        <!---start for list div-->
                        <div class="card">
                            <div class="card-header bg-light-info">
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h4 class="card-title">Approver for Position [<span
                                                class="font-weight-bold text-primary"><?php echo $staff_position; ?></span>]
                                        </h4>
                                        <h6 class="card-subtitle">معتمد المنصب</h6>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <div>
                                    <!-- button class viewHistory not working yet... -->
                                    <button class="btn btn-sm btn-primary viewHistory"><i class="fa fa-search"></i> View
                                        Approver Changes/Updates History</button>
                                    <input type="hidden" value="<?php echo $pid; ?>" class="g_position_id" />
                                </div>
                                <div class="table-responsive">
                                    <table id="dynamicTable" class="display table-hover table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sequence</th>
                                                <th>Approver Position</th>
                                                <th>Approver Name</th>
                                                <th>Status</th>
                                                <th>Is Final</th>
                                                <th>Entered By</th>
                                                <th>Entered Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                            $position_id = $_GET['pid'];
                                                            $fetchApprovers = new DbaseManipulation;
                                                            $rows = $fetchApprovers->readData("SELECT a.*, p.title as approverTitle, 
                                                            concat(es.firstName,' ',es.secondName,' ',es.thirdName,' ',es.lastName) as approverName,
                                                            concat(c.firstName,' ',c.secondName,' ',c.thirdName,' ',c.lastName) as createdBy
                                                            FROM approvalsequence_standardleave as a 
                                                            LEFT OUTER JOIN staff_position as p ON p.id = a.approver_id
                                                            LEFT OUTER JOIN employmentdetail as e ON e.position_id = a.approver_id
                                                            LEFT OUTER JOIN staff as es ON es.staffId = e.staff_id
                                                            LEFT OUTER JOIN staff as c ON c.staffId = a.created_by
                                                            WHERE a.position_id = $position_id AND e.isCurrent = 1 AND a.active = 1
                                                            ORDER BY a.sequence_no");
                                                            foreach($rows as $row){ //Yung mga wala pang position_id sa employmentdetail table, hindi lalabas dito...
                                                                ?>
                                            <tr>
                                                <td><?php echo $row['sequence_no'].'.'; ?></td>
                                                <td><a class="text-success approverTitleClick" style="cursor:pointer"
                                                        data-id="<?php echo $row['id']; ?>"
                                                        data-approver_id="<?php echo $row['approver_id']; ?>"
                                                        data-sequence_no="<?php echo $row['sequence_no']; ?>"
                                                        data-statactive="<?php echo $row['active']; ?>"><?php echo $row['approverTitle']; ?></a>
                                                </td>
                                                <td><?php echo $row['approverName']; ?></td>
                                                <td><?php echo $row['active'] ? "<span class='badge badge-success'>Active</span>" : "<span class='badge badge-danger'>Not Active</span>"; ?>
                                                </td>
                                                <td><?php echo $row['is_final'] ? "<span class='badge badge-success'>YES</span>" : "<span class='badge badge-danger'>No</span>"; ?>
                                                </td>
                                                <td><?php echo $row['createdBy']; ?></td>
                                                <td><?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?></td>
                                            </tr>
                                            <?php    
                                                            }
                                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end table-responsive-->
                            </div>
                            <!--end card body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-lg-6-->
                </div>
                <!--end row-->
            </div>
            <footer class="footer">
                <?php include('include_footer.php'); ?>
            </footer>
        </div>
    </div>
    <?php include('include_scripts.php'); ?>
    <script>
    $('.viewHistory').click(function() {
        var position_id = $('.g_position_id').val();
        var data = {
            position_id: position_id
        }
        $.ajax({
            url: 'ajaxpages/leaves/settings/standardleave_history.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(e) {
                if (e.error == 1) {
                    bootbox.alert(
                        "<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing."
                    );
                } else {
                    bootbox.alert({
                        title: "<span class='text-primary'><i class='fa fa-info-circle'></i> Information</span>",
                        message: e.message,
                        size: 'large',
                        animate: true,
                    });
                }
            },
            error: function(e) {}
        });
    });
    $(".position_id").change(function() {
        var position_id = $('.position_id').val();
        var data = {
            position_id: position_id
        }
        $.ajax({
            url: 'ajaxpages/leaves/settings/queryapproverinfo.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(e) {
                if (e.error == 1) {
                    bootbox.alert(e.message);
                } else {
                    $('.approver_staff_id').val(e.staff_id);
                    $('.approver_name').val(e.staff_name);
                    $('.notes').focus();
                }
            },
            error: function(e) {}
        });
    });
    $('.approverTitleClick').click(function() {
        var id = $(this).data('id');
        $('.id').val(id);
        var sequence_no = $(this).data('sequence_no');
        $('.sequence_no').val(sequence_no);
        var approver_id = $(this).data('approver_id');
        $('.previous_approver').val(approver_id);
        var statactive = $(this).data('statactive');
        if (statactive == 1) {
            statActiveText = "Active";
            var adding = "Not-Active";
            var statactiverev = 0;
        } else {
            statActiveText = "Not-Active";
            var adding = "Active";
            var statactiverev = 1;
        }
        $('.statActive').empty();
        $('.statActive').append($('<option>').text(adding).attr('value', statactiverev));
        $('.statActive').append($('<option selected>').text(statActiveText).attr('value', statactive));
        var data = {
            id: id,
            approver_id: approver_id
        }
        $.ajax({
            url: 'ajaxpages/leaves/settings/edit_approver_standardleave.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(e) {
                if (e.error == 1) {
                    bootbox.alert(
                        "<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing."
                    );
                } else {
                    //$('.position_id').empty();
                    $('.position_id').append($('<option selected>').text(e.approver_position).attr(
                        'value', e.approver_id));
                    $('.approver_staff_id').val(e.approver_staff_id);
                    $('.approver_name').val(e.approver_staff_name);
                    $('#is_final1').val(e.is_final_approver);
                    $('.sequence_No').append($('<option selected>').text(e.sequence_no_approver)
                        .attr(
                            'value', e.$sequence_no_approver));

                    // console.log(e.is_final_approver);
                    $('.notes').focus();
                    $('.submitApprovalSequence').hide();
                    $(
                        '.updateApprovalSequence').show();
                }
            },
            error: function(e) {}
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