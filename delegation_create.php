<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
?>
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Create Delegation</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Delegation</li>
                                        <li class="breadcrumb-item">Create Delegation</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 col-xs-18">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Delegation Form</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                                if(isset($_POST['submit'])){
                                                    $staffIdTo = $_POST['staffIdTo'];
                                                    $startDate = $_POST['startDate'];
                                                    $endDate = $_POST['endDate'];
                                                    $sql = "SELECT d.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as delegator FROM delegation as d LEFT OUTER JOIN staff as s ON s.staffId = d.staffIdFrom WHERE d.staffIdTo = '$staffIdTo' AND d.startDate <= '$startDate' AND d.endDate >= '$endDate' AND d.status NOT IN ('Finished');";
                                                    $rows = $helper->readData($sql);
                                                    if($helper->totalCount != 0) {
                                                        ?>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#myModalFail').modal('show');
                                                                });
                                                            </script>
                                                        <?php
                                                    } else {
                                                            $submit = new DbaseManipulation;
                                                            $roles = array();
                                                            $shl = 0; $stl = 0; $otl = 0; $clr = 0;
                                                            $delegation_task_ids = $_POST['delegation_task_id'];
                                                            foreach ($delegation_task_ids as $id){
                                                                //*****/Presently coding the roles as static code NOT database dependent, need to improve this in future... 
                                                                if($id == 1) { $shl = 1; array_push($roles,'Short Leave Approval'); }
                                                                if($id == 2) { $stl = 1; array_push($roles,'Standard Leave Approval'); }
                                                                if($id == 3) { $otl = 1; array_push($roles,'Overtime Leave Approval'); }
                                                                if($id == 4) { $clr = 1; array_push($roles,'Clearance Approval'); }
                                                            }
                                                            $requestNo = $_POST['requestNo'];
                                                            $staffIdFrom = $staffId;
                                                            $staffIdTo = $_POST['staffIdTo'];
                                                            $startDate = $_POST['startDate'];
                                                            $endDate = $_POST['endDate'];
                                                            $status = 'Pending';
                                                            $reason = $_POST['reason'];
                                                            $createdBy = $staffId;
                                                            
                                                            $fields = [
                                                                'requestNo'=>$requestNo,
                                                                'shl'=>$shl,
                                                                'stl'=>$stl,
                                                                'otl'=>$otl,
                                                                'clr'=>$clr,
                                                                'staffIdFrom'=>$staffIdFrom,
                                                                'staffIdTo'=>$staffIdTo,
                                                                'startDate'=>$startDate,
                                                                'endDate'=>$endDate,
                                                                'status'=>$helper->cleanString($status),
                                                                'reason'=>$reason,
                                                                'createdBy'=>$createdBy
                                                            ];
                                                            if($submit->insert("delegation",$fields)){
                                                                $last_id = $submit->singleReadFullQry("SELECT TOP 1 id FROM delegation ORDER BY id DESC");
                                                                $delegation_id = $last_id['id'];
                                                                $fieldsHistory = [
                                                                    'delegation_id'=>$delegation_id,
                                                                    'requestNo'=>$requestNo,
                                                                    'staff_id'=>$staffId,
                                                                    'status'=>'Delegation is Pending For Approval',
                                                                    'notes'=>$reason,
                                                                    'ipAddress'=>$submit->getUserIP()
                                                                ];
                                                                if($submit->insert("delegation_history",$fieldsHistory)){
                                                                    $roles_descriptions = implode(', ', $roles);
                                                                    $from_name = 'hrms@nct.edu.om';
                                                                    $from = 'HRMS - 3.0';
                                                                    $subject = 'NCT-HRMD SYSTEM ROLE DELEGATION';
                                                                    $d = '-';
                                                                    $message = '<html><body>';
                                                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                    $message .= "<h3>NCT-HRMS 3.0</h3>";
                                                                    $message .= '<p>The following system role has been delegated/assigned into your HR account. Kindly login to HR System for more details.</p>';
                                                                    $message .= '<p><strong>'.$roles_descriptions.'</strong></p>';
                                                                    $message .= "</body></html>";
                                                                    $transactionDate = date('Y-m-d H:i:s',time());

                                                                    //Save Email Information in the system_emails table...
                                                                    $to = array();
                                                                    array_push($to,$helper->getContactInfo(2,$staffId,'data'),$helper->getContactInfo(2,$staffIdTo,'data'));
                                                                    $recipients = implode(', ', $to);
                                                                    $emailFields = [
                                                                        'requestNo'=>$requestNo,
                                                                        'moduleName'=>'Create Delegation',
                                                                        'sentStatus'=>'Pending',
                                                                        'recipients'=>$recipients,
                                                                        'fromName'=>$from_name,
                                                                        'comesFrom'=>$from,
                                                                        'subject'=>$subject,
                                                                        'message'=>$message,
                                                                        'createdBy'=>$staffId,
                                                                        'dateEntered'=>$transactionDate,
                                                                        'dateSent'=>$transactionDate
                                                                    ];
                                                                    $saveEmail = new DbaseManipulation;
                                                                    $saveEmail->insert("system_emails",$emailFields);
                                                                    ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModal').modal('show');
                                                                            });
                                                                        </script>
                                                                    <?php
                                                                }    
                                                            }
                                                    }            
                                                }
                                            ?>
                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <?php
                                                        $requestNo = $helper->requestNo('DEL-',"delegation");
                                                    ?>    
                                                    <label class="col-sm-3 control-label"><h3 class="text-muted text-success">New Delegation</h3></label>
                                                    <div class="col-sm-9">
                                                        <h3 class="text-muted text-success"><span class="badge badge-primary"><?php echo $requestNo; ?></span></h3>        
                                                    </div>
                                                </div>    
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Delegate Role</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <?php
                                                                        $roles = $helper->readData("SELECT id, display_name FROM delegation_pages WHERE active = 1 ORDER BY id");
                                                                        if($helper->totalCount != 0) {
                                                                            foreach($roles as $role){
                                                                                ?>
                                                                                    <fieldset>
                                                                                        <label class="custom-control custom-checkbox">
                                                                                            <input type="checkbox" value="<?php echo $role['id']; ?>" name="delegation_task_id[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one role to be delegate." class="custom-control-input">
                                                                                            <span class="custom-control-label"><?php echo $role['display_name']; ?></span>
                                                                                        </label>
                                                                                    </fieldset>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span> Staff Name</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="requestNo" value="<?php echo $requestNo ?>" />
                                                                <select name="staffIdTo" class="form-control staffIdTo" required data-validation-required-message="Please select Staff">
                                                                    <option value="">Select Staff</option>
                                                                    <?php
                                                                        $sql = "SELECT sp.id as position_id, e.staff_id, 
                                                                                concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                                sp.code, sp.title, e.department_id, e.section_id 
                                                                                FROM staff_position sp INNER JOIN employmentdetail e
                                                                                INNER JOIN staff s ON e.staff_id = s.staffId
                                                                                ON sp.id = e.position_id
                                                                                WHERE (sp.code LIKE '%HO%' OR sp.id < 5) 
                                                                                AND e.isCurrent = 1 AND e.status_id = 1 AND (e.department_id = $logged_in_department_id OR sp.id IN (1,2,3,4)) AND e.staff_id != '$staffId'
                                                                                ORDER BY sp.id";
                                                                        $rows = $helper->readData($sql);
                                                                        foreach ($rows as $row) {
                                                                            ?>
                                                                            <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['staffName']; ?></option>
                                                                            <?php
                                                                        }
                                                                        if($myPositionId <= 4) {
                                                                            if($myPositionId == 4) { // ADSA --> HOD -OJT, HOD - Counseling, HOD - Student Activity
                                                                                $sqlUnderADSA = "SELECT sp.id as position_id, e.staff_id, 
                                                                                concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                                sp.code, sp.title, e.department_id, e.section_id 
                                                                                FROM staff_position sp INNER JOIN employmentdetail e
                                                                                INNER JOIN staff s ON e.staff_id = s.staffId
                                                                                ON sp.id = e.position_id
                                                                                WHERE (sp.id IN (14,15,16)) 
                                                                                AND e.isCurrent = 1 AND e.status_id = 1";
                                                                                $rows = $helper->readData($sqlUnderADSA);
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['staffName']; ?></option>
                                                                                    <?php
                                                                                }
                                                                            } else if($myPositionId == 3) { // ADAA --> HOD - Information Technology, HOD - Engineering, HOD - Business
                                                                                $sqlUnderADAA = "SELECT sp.id as position_id, e.staff_id, 
                                                                                concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                                sp.code, sp.title, e.department_id, e.section_id 
                                                                                FROM staff_position sp INNER JOIN employmentdetail e
                                                                                INNER JOIN staff s ON e.staff_id = s.staffId
                                                                                ON sp.id = e.position_id
                                                                                WHERE (sp.id IN (7,8,9)) 
                                                                                AND e.isCurrent = 1 AND e.status_id = 1";
                                                                                $rows = $helper->readData($sqlUnderADAA);
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['staffName']; ?></option>
                                                                                    <?php
                                                                                }
                                                                            } else if($myPositionId == 2) { // ADAFA --> HOD - Admin Affairs, HOD - Financial Affairs, HOD - Human Resources
                                                                                $sqlUnderADAFA = "SELECT sp.id as position_id, e.staff_id, 
                                                                                concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                                sp.code, sp.title, e.department_id, e.section_id 
                                                                                FROM staff_position sp INNER JOIN employmentdetail e
                                                                                INNER JOIN staff s ON e.staff_id = s.staffId
                                                                                ON sp.id = e.position_id
                                                                                WHERE (sp.id IN (10,11,12)) 
                                                                                AND e.isCurrent = 1 AND e.status_id = 1";
                                                                                $rows = $helper->readData($sqlUnderADAFA);
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['staffName']; ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Start and End Date</label>
                                                    <div class="col-sm-9">
                                                        <div class='input-group mb-3'>            
                                                            <input type='text' class="form-control addDateRange" required data-validation-required-message="Please Select Delegation Date" />
                                                            <input type="hidden" name="startDate" value="<?php echo date('Y-m-d'); ?>" class="form-control startDate" />
                                                            <input type="hidden" name="endDate" value="<?php echo date('Y-m-d'); ?>" class="form-control endDate" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="far fa-calendar-alt"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Number of Days</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" class="form-control noOfDays" required data-validation-required-message="Number of days is required" readonly />
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
                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Notes/Reason</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <textarea name="reason" class="form-control" rows="2" required data-validation-required-message="Note is required" minlength="10"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="far fa-comment"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-18">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Information!</h4>
                                        <small>Kindly fill out the delegation form and click on submit button. An approval cycle will be made and you will be updated via college email.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <script>
                    $(document).ready(function($) {
                        $(".staffIdTo").focus();
                        $(".addDateRange").prop("disabled", true);
                        $(".staffIdTo").change(function() {
                            $(".addDateRange").focus();
                            if($(this).val() != "") {
                                $(".addDateRange").prop("disabled", false);
                            } else {
                                $(".addDateRange").prop("disabled", true);
                            }   
                        });
                    });
                </script>
                <?php include('include_scripts.php'); ?>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Delegation of task has been submitted successfully!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModalFail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-exclamation-triangle'></i> Failure</h3>
                                <h5>Delegation of task was not submitted successfully! <br/><br/>Delegation of roles to the selected staff, starting and ending date conflicts to other delegations.<br/><br/>Please provide the correct staff name, starting and ending date.</h5>
                                <a href="" class="btn btn-danger"><i class='fa fa-check'></i> OK</a>
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