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
                 $isAcademic = $helper->fieldNameValue("department",$logged_in_department_id,'isAcademic');                            
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Current Recommendation List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Awarding </li>
                                        <li class="breadcrumb-item">Current Recommendation List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header bg-light-success2" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Recommendation List for [<span class="text-primary"><?php echo date('Y'); ?> - <?php echo date('F'); ?></span>]</h4>
                                        </div>
                                        <div class="card-body bg-light-success">
                                            <div class="table-responsive">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>    
                                                            <th>Department</th>
                                                            <th>Name</th>
                                                            <th>Catagory</th>
                                                            <th>Mark</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $currMonth  = date('F');
                                                            $currYear  = date('Y');
                                                            $winnerChecker = new DbaseManipulation;
                                                            $chk = $winnerChecker->singleReadFullQry("SELECT COUNT(id) as ctr FROM award_candidate WHERE canMonth = '$currMonth' AND canYear = '$currYear' AND canStatus = 'Winner'");
                                                            if($chk['ctr'] > 0) {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="6" class="text-center"><span class="alert alert-info">An Employee of the month winner for the period of <?php echo $currMonth,', ',$currYear; ?> has already been declared. Click <a href="award_winner_list.php">HERE</a> to check the result.</span></td>
                                                                </tr>
                                                                <?php
                                                            } else {
                                                                $list = new DbaseManipulation;
                                                                $rows = $list->readData("SELECT d.id, d.name as department, d.isAcademic, c.id as canId, c.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, c.score as mark FROM department AS d LEFT OUTER JOIN award_candidate as c ON d.id = c.department_id LEFT OUTER JOIN staff as s ON c.staffId = s.staffId AND c.canMonth = '$currMonth' AND c.canYear = '$currYear' AND c.canStatus = 'Recommended'");
                                                                if($list->totalCount != 0) {
                                                                    $i = 0;
                                                                    foreach ($rows as $row) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['staffName']; ?></td>
                                                                            <td><?php echo $row['isAcademic'] ? "Academic" : "Non-Academic"; ?></td>
                                                                            <td><a href="#" class="viewScore" data-id="<?php echo $row['canId']; ?>" data-aca="<?php echo $row['isAcademic']; ?>"><?php echo number_format($row['mark'],2); ?></a></td>
                                                                            <td>
                                                                                <?php 
                                                                                    if($row['staffId'] != '') {
                                                                                        ?>
                                                                                        <a style="color: white" class="btn btn-info waves-effect waves-light btnSelectWinnerModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['canId']; ?>" data-sid="<?php echo $row['staffId']; ?>"><i class="fa fa-paper-plane"></i> Select This as Winner</a>
                                                                                <?php 
                                                                                    }
                                                                                ?>    
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                    }
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
                <script>
                    $(document).ready(function() {
                        $('.btnSelectWinnerModal').click(function(e){
                            var id = $(this).data('id');
                            var staffId = $(this).data('sid');
                            var data = {
                                id : id,
                                staffId : staffId
                            }
                            $.ajax({
                                url  : 'ajaxpages/awarding/staffInfo.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 0){
                                        $('.awardId').val(e.id);
                                        $('.staffName').val(e.staffName);
                                        $('.departmentName').val(e.department);
                                        $('.jobTitle').val(e.jobtitle);
                                        $('.category').val(e.category);
                                        $('.mark').val(e.mark);
                                    } else {
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Unable to fetch staff information.");
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });

                        $('.btnSubmitWinner').click(function(e){
                            bootbox.hideAll();
                                bootbox.confirm({
                                    message: "This action will declare the selected staff as the Employee of the month. Do you want to continue?",
                                    buttons: {
                                        confirm: {
                                            label: 'Continue',
                                            className: 'btn-success btn-sm'
                                        },
                                        cancel: {
                                            label: 'Cancel',
                                            className: 'btn-danger btn-sm'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result==true){
                                            var aydi = $('.awardId').val();
                                            var staffId = $('.awardStaffId').val();
                                            var reason = $('.reason').val();
                                            var data = {
                                                id : aydi,
                                                awarderId : staffId,
                                                reason : reason
                                            }
                                            if(reason.length < 1) {
                                                bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Reason for selecting the staff as winner is a required field.");
                                            } else {
                                                $.ajax({
                                                    url  : 'ajaxpages/awarding/declare.php'
                                                    ,type    : 'POST'
                                                    ,dataType: 'json'
                                                    ,data    : data
                                                    ,success : function(e){
                                                        if(e.error == 0){
                                                            /*bootbox.alert({
                                                                title: "<span class='text-success'><i class='fa fa-info-circle'></i> Success!</span>", 
                                                                message: e.msg,
                                                                callback: function (result) {
                                                                    if(result==true){
                                                                        window.location.href = "award_winner_list.php";
                                                                    }
                                                                }
                                                            })*/
                                                            alert(e.msg);
                                                            window.location.href = "award_winner_list.php";
                                                        } else {
                                                            
                                                        }   
                                                    }
                                                    ,error  : function(e){
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                        });
                        $('.viewScore').click(function(e){
                            var id = $(this).data('id');
                            var aca = $(this).data('aca');
                            var data = {
                                id : id,
                                aca : aca
                            }
                            $.ajax({
                                url  : 'ajaxpages/awarding/viewScore.php'
                                ,type    : 'POST'
                                ,dataType: 'json'
                                ,data    : data
                                ,success : function(e){
                                    if(e.error == 0){
                                        bootbox.alert({
                                            message: e.msg,
                                            size: 'large'
                                        });
                                    } else {
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Unable to fetch score information.");
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        });
                    });    
                </script>
                <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Selection for Employee of the Month [<span class="text-primary">2020-January</span>]</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Staff Name</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control awardStaffId" value="<?php echo $staffId; ?>">
                                                    <input type="hidden" class="form-control awardId">
                                                    <input type="text" class="form-control staffName" readonly> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Department</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                     <input type="text" class="form-control departmentName" readonly> 
                                                   <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-briefcase"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Job Title</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                <input type="text" name="" class="form-control jobTitle" readonly> 
                                                   <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-file-alt"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Category</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                <input type="text" name="" class="form-control category" readonly> 
                                                   <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-tags"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Mark</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                <input type="text" name="" class="form-control mark" readonly> 
                                                   <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-percent"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Reason for Selecting This Staff:</label>
                                        <textarea class="form-control reason"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <p class="text-small"><i class="fas fa-exclamation-triangle text-danger"></i>Warning!!! Once you click Submit button you cannot change it anymore!</p>
                                <br>
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light btnSubmitWinner">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>             
</html>