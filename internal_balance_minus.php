<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;                        
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Minus Internal Balance to Staff</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Leave Setttings</li>
                                        <li class="breadcrumb-item">Minus Internal Balance</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card">
                                        <div class="card-body">
                                            <script>
                                                if (window.history.replaceState) { //Preventing system to re-submit once refreshed
                                                    window.history.replaceState( null, null, window.location.href );
                                                }
                                            </script>
                                            <?php
                                                if(isset($_POST['submitMinus'])){
                                                    $save = new DbaseManipulation;
                                                    $internalleavebalance_id = $_POST['internalleavebalance_id'];
                                                    $staff_id = $_POST['staffId'];
                                                    $startDate = date('Y-m-d');
                                                    $endDate = date('Y-m-d');
                                                    $total = $_POST['total'];
                                                    $notes = $save->cleanString($_POST['reason']).": ".$save->cleanString($_POST['notes']);
                                                    $createdBy = $staffId;
                                                    $fields = [
                                                        'internalleavebalance_id'=>$internalleavebalance_id,
                                                        'leavetype_id'=>17,
                                                        'staffId'=>$staff_id,
                                                        'startDate'=>$startDate,
                                                        'endDate'=>$endDate,
                                                        'total'=>"-".$total,
                                                        'status'=>'Approved',
                                                        'notes'=>$notes,
                                                        'addType'=>2,
                                                        'createdBy'=>$createdBy
                                                    ];
                                                    //echo $save->displayArr($fields);
                                                    if($save->insert("internalleavebalancedetails",$fields)) {
                                                        $result = $save->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM staff as s WHERE s.staffId = '$staff_id'");
                                                        $email_staffName = $result['staffName'];
                                                        $staffEmail = $save->getContactInfo(2,$staff_id,'data');
                                                        $to = array();
                                                        array_push($to,$logged_in_email,$staffEmail);
                                                        $transactionDate = date("Y-m-d H:i:s",time());
                                                        $leaveType = $save->fieldNameValue("leavetype",17,"name");
                                                        $from_name = 'hrms@nct.edu.om';
                                                        $from = 'HRMS - 3.0';
                                                        $subject = 'NCT-HRMD INTERNAL LEAVE HAS BEEN FILED FOR '.strtoupper($email_staffName);
                                                        $d = '-';
                                                        $message = '<html><body>';
                                                        $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                        $message .= "<h3>NCT-HRMS 3.0 INTERNAL LEAVE DETAILS AS FOLLOWS</h3>";
                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$internalleavebalance_id."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$email_staffName."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>FILED DATE:</strong> </td><td>".date('d/m/Y H:i:s')."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>FILED BY:</strong> </td><td>".$logged_name."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>NOTES/COMMENTS:</strong> </td><td>".$notes."</td></tr>";
                                                        $message .= "</table>";
                                                        $message .= "</body></html>";
                                                        $emailRecipient = new sendMail;
                                                        if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)) {
                                                            //Save Email Information in the database...
                                                            $recipients = implode(', ', $to);    
                                                            $emailFields = [
                                                                'requestNo'=>$internalleavebalance_id,
                                                                'moduleName'=>'Internal Balance Filed - Minus',
                                                                'sentStatus'=>'Sent',
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
                                                            //Ends...
                                                        } else {
                                                            //Save Email Information in the database...
                                                            $recipients = implode(', ', $to);    
                                                            $emailFields = [
                                                                'requestNo'=>$internalleavebalance_id,
                                                                'moduleName'=>'Internal Balance Filed - Minus',
                                                                'sentStatus'=>'Failed',
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
                                                        }
                                            ?>
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>Internal leave balance has been processed successfully in the system.</p>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Minus Internal Balance Form (Per Staff) </h3>
                                                    <h6 class="card-subtitle">إستمارة خصم الرصيد الداخلي (حسب الموظف)</h6>
                                                </div>
                                            </div>
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label">Leave Minus ID</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                        <?php 
                                                            $request = new DbaseManipulation;
                                                            $requestNo = $request->internalLeaveBalanceId("MIL-","internalleavebalancedetails");
                                                        ?>
                                                        <h3 class="text-muted text-success"><span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3> </li>
                                                        <input type="hidden" name="internalleavebalance_id" value="<?php echo $requestNo; ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Department</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
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
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Staff</label>
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
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-users"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-9 boxCurrentInternalBalance" style="display:none">
                                                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Current Internal Leave Balance: <span class="internalBalance"></span></h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Reason</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                    <select name="reason" class="form-control" required data-validation-required-message="Please select reason">
                                                                    <option value="">Select Reason</option>
                                                                    <option value="Mistake">Mistake</option>
                                                                    <option value="Absent">Absent</option>    
                                                                </select>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-question"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Number of Days<span class="text-danger"> (Minus)</span></label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="number" name="total" class="form-control" required data-validation-required-message="Number of days for MINUS Balance is required"> 
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label  class="col-sm-3 control-label">Notes/Comments</label>                  
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <textarea name="notes" class="form-control" rows="2" required data-validation-required-message="Reasons for MINUS Balance is required" minlength="20"></textarea>
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group row">
                                                    <label  class="col-sm-3 control-label">Attachment</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="file" name="attachment" class="form-control"> 
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
                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-3 col-sm-9">
                                                        <button type="submit" name="submitMinus" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
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

                            $(".staffDropDown").change(function() {
                                var staffId = $('.staffDropDown').val();
                                var data = {
                                    staffId : staffId
                                }
                                $.ajax({
                                    url	 : 'ajaxpages/leaves/minus-internal/internalbalance.php'
                                    ,type	 : 'POST'
                                    ,dataType: 'json'
                                    ,data	 : data
                                    ,success : function(e){
                                        if(e.error == 1){
                                            bootbox.alert(e.message);
                                        } else {
                                            $('.internalBalance').text(e.balance);
                                            $('.boxCurrentInternalBalance').show();
                                        }	
                                    },error	: function(e){
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