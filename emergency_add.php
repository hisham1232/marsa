<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;                        
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">ADD Emergency Balance to Staff</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Emergency Balance</a></li>
                                        <li class="breadcrumb-item">ADD Staff Emergency Balance </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-18"><!---start  Re-Set Emergency form div-->
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">ADD Emergency Balance Form</h3>
                                                    <h6 class="card-subtitle text-info"><i class="fas fa-info-circle"></i> Select Staff with Additional Emergency Balance for this memo.</h6>
                                                </div>
                                                <div class="ml-auto">
                                                        <ul class="list-inline">
                                                        <li class="none">
                                                            <?php 
                                                                $request = new DbaseManipulation;
                                                                $requestNo = $request->emergencyLeaveBalanceId("AEL-","emergencyleavebalancedetails");
                                                            ?>
                                                            <h4 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h4> </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <?php
                                                if(isset($_POST['submitEmergency'])){
                                                    $save = new DbaseManipulation;
                                                    $fields = [
                                                        'emergencyleavebalance_id'=>$_POST['emergencyleavebalance_id'],
                                                        'staffId'=>$_POST['staffId'],
                                                        'startDate'=>date('Y-m-d'),
                                                        'endDate'=>date('Y-m-d'),
                                                        'total'=>$_POST['noOfDays'],
                                                        'status'=>'Saved',
                                                        'notes'=>$_POST['notes'],
                                                        'addType'=>1,
                                                        'createdBy'=>$staffId
                                                    ];
                                                    //echo $save->displayArr($fields);
                                                    if($save->insert("emergencyleavebalancedetails",$fields)){
                                            ?>
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>Emergency leave balance has been processed successfully in the system.</p>
                                                        </div>
                                            <?php
                                                        //Save Email Information in the system_emails table...    
                                                        $from_name = 'hrms@nct.edu.om';
                                                        $from = 'HRMS - 3.0';
                                                        $subject = 'NCT-HRMD EMERGENCY LEAVE BALANCE CREDITED';
                                                        $d = '-';
                                                        $message = '<html><body>';
                                                        $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                        $message .= "<h3>NCT-HRMS 3.0</h3>";
                                                        $message .= '<p>An emergency leave balance has been added and credited into your HR account. Kindly login to HR System for more details.</p>';
                                                        $message .= "</body></html>";
                                                        $transactionDate = date('Y-m-d H:i:s',time());
                                                        $staff_id = $_POST['staffId'];
                                                        $to = array();
                                                        array_push($to,$save->getContactInfo(2,$staff_id,'data'));
                                                        $recipients = implode(', ', $to);
                                                        $emailFields = [
                                                            'requestNo'=>$_POST['emergencyleavebalance_id'],
                                                            'moduleName'=>'Added Emergency Balance',
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
                                                        //echo $save->displayArr($emailFields);
                                                        $saveEmail = new DbaseManipulation;
                                                        $saveEmail->insert("system_emails",$emailFields);
                                                    }
                                                }
                                            ?>            
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Department</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="hidden" name="emergencyleavebalance_id" value="<?php echo $requestNo; ?>" />
                                                                <select name="department_id" class="form-control department_id" required data-validation-required-message="Please select department">
                                                                    <option value="">Select Department</option>
                                                                    <?php 
                                                                        $rows = $dropdown->readData("SELECT id, name FROM department WHERE active = 1 ORDER BY id");
                                                                        $selected_department_id = $_GET['did'];
                                                                        foreach ($rows as $row) {
                                                                            if($row['id'] == $selected_department_id) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['id']; ?>" selected><?php echo $row['name']; ?></option>
                                                                                <?php        
                                                                            } else {    
                                                                    ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                    <?php
                                                                            }            
                                                                        }    
                                                                    ?>
                                                                </select>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-briefcase"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Staff Name</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select class="form-control staffDropDown" name="staffId" required data-validation-required-message="Please select staff">
                                                                    <?php
                                                                        if(isset($_GET['uid'])) {
                                                                            $uid = $_GET['uid'];
                                                                            $staff_name = $dropdown->getStaffName($uid,'firstName','secondName','thirdName','lastName');
                                                                            ?>
                                                                                <option value="<?php echo $uid; ?>" selected><?php echo $staff_name; ?></option>    
                                                                            <?php
                                                                        } else {
                                                                    ?>    
                                                                                <option value="">Select Staff</option>
                                                                    <?php
                                                                        }
                                                                    ?>        
                                                                </select>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Number of Days</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="number" name="noOfDays" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Notes/Reasons </label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <textarea name="notes" class="form-control" rows="2" required data-validation-required-message="Notes/Reasons is required" minlength="10"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group row">
                                                    <label  class="col-sm-3 control-label">Attachments</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="file" name="fileToUpload" class="form-control">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-file-pdf"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label">Entered By</label>                  
                                                    <div class="col-sm-9">
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
                                                    <label  class="col-sm-3 control-label">Entered Date</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo date('d/m/Y H:i:s'); ?>" class="form-control" readonly>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submitEmergency" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>
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
                        $(".department_id").change(function() {
                            var department_id = $('.department_id').val();
                            var data = {
                                department_id : department_id
                            }
                            $.ajax({
                                url	 : 'ajaxpages/leaves/minus-internal/staff.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert(e.message);
                                    } else {
                                        $('.staffDropDown').empty();
                                        $('.staffDropDown').append($('<option>').text("Select Staff").attr('value', ''));
                                        $.each(e.rows, function(i, j){
                                            $('.staffDropDown').append($('<option>').text(j.staffName).attr('value', j.staff_id));
                                        });
                                    }	
                                }
                                ,error	: function(e){
                                }
                            });
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