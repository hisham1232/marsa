<?php    
    include('include_headers_login.php');                                 
?>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <!-- <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg> -->
    </div>
    <section id="wrapper">
        <div class="login-register" style="background-image:url(assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-header p-20 m-b-20" style="border-bottom: double; border-color: #28a745">
                    <div>
                        <center><img src="assets/images/logo-text-login.png" alt="homepage" class="dark-logo" />
                        </center>
                    </div>
                </div>
                <div class="card-body">
                    <?php 
                    
                   
                        if(isset($_POST['submitLogin'])){
                            $checkLogin = new DbaseManipulation;
                            $Email = $checkLogin->cleanString($_POST['Email']);
                            // $password = md5($checkLogin->cleanString($_POST['s_password']));
                            echo "SELECT  [staff_id] FROM  [contactdetails] where  data='$Email' ";

                             $loginData = $checkLogin->singleReadFullQry("SELECT  [staff_id] FROM  [contactdetails] where  data='$Email' ");
                            // echo "SELECT  [staff_id] FROM  [contactdetails] where  data='$Email' ";
                             if($checkLogin->totalCount == 0) {
                    ?>
                    <h4 class="box-title m-b-20 p-b-10 text-danger">
                        <center><i class='fa fa-exclamation-triangle'></i> Invalid User Email !</center>
                    </h4>
                    <?php            
                            } else {
                                echo"hi";
                                 $token = md5(rand());
                                 $staff_id = $loginData['staff_id'];
                                 $update = new DbaseManipulation;
                                 $staff_id = $loginData['staff_id'];
                               if ( $update->executeSQL("UPDATE [users] SET [token] = '$token' WHERE username = $staff_id"))
                               {
                                 $login_id_hashed = hash_hmac('sha256',$staff_id,$token);  
                                 

                                 ///////////////////////////////////////////////////////////////////

                                 $contact_details = new DbaseManipulation;
                                 $gsm = $contact_details->getContactInfo(1,$staff_id,'data');
                                 $getIdInfo = new DbaseManipulation;
                               //  $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                 $from_name = 'hrms@nct.edu.om';
                                 $from = 'HRMS - 3.0';
                                 $subject = 'NCT-HRMD STAFF Reset Password  ';
                                 $message = '<html><body>';
                                //  $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                 $message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
                                 $message .= "<h3>This email for reset HR system Password </h3>";
                                 $message .= "<h3><a href='http://localhost/hrmd3/nwePassword.php?token=$token'> Clik the link for reset password </a></h3>";
 
                                 $message .= "</body></html>";
                                 $to = array();
                                  array_push($to,$Email);
                                 $emailParticipants = new sendMail;
                                 $a=1;
                                 if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
                                     //Save Email Information in the system_emails table...
                                    //  $from_name = $from_name;
                                    //  $from = $from;
                                    //  $subject = $subject;
                                    //  $message = $message;
                                    //  $transactionDate = date('Y-m-d H:i:s',time());
                                    //  $to = $to;
                                    //  $recipients = implode(', ', $to);
                                    //  $emailFields = [
                                    //      'requestNo'=>$newReqNo,
                                    //      'moduleName'=>'NCT-HRMD STAFF Reset Password  -'.$staff_id,
                                    //      'sentStatus'=>'Sent',
                                    //      'recipients'=>$recipients,
                                    //      'fromName'=>$from_name,
                                    //      'comesFrom'=>$from,
                                    //      'subject'=>$subject,
                                    //      'message'=>$message,
                                    //      'createdBy'=>$staffId,
                                    //      'dateEntered'=>$transactionDate,
                                    //      'dateSent'=>$transactionDate
                                    //  ];
                                    //  $saveEmail = new DbaseManipulation;
                                    //  $saveEmail->insert("system_emails",$emailFields);  

                                     header("Location: resetPassword.php?massage=true");
 
                                 } else {
                                     //Save Email Information in the system_emails table...
                                    //  $from_name = $from_name;
                                    //  $from = $from;
                                    //  $subject = $subject;
                                    //  $message = $message;
                                    //  $transactionDate = date('Y-m-d H:i:s',time());
                                    //  $to = $to;
                                    //  $recipients = implode(', ', $to);
                                    //  $emailFields = [
                                    //      'requestNo'=>$newReqNo,
                                    //      'moduleName'=>'NCT-HRMD STAFF Reset Password -'.$staff_id,
                                    //      'sentStatus'=>'Failed',
                                    //      'recipients'=>$recipients,
                                    //      'fromName'=>$from_name,
                                    //      'comesFrom'=>$from,
                                    //      'subject'=>$subject,
                                    //      'message'=>$message,
                                    //      'createdBy'=>$staffId,
                                    //      'dateEntered'=>$transactionDate,
                                    //      'dateSent'=>$transactionDate
                                    //  ];
                                    //  $saveEmail = new DbaseManipulation;
                                    //  $saveEmail->insert("system_emails",$emailFields);  
                                     header("Location: resetPassword.php?massage=false");

                                 }    
                                 ///////////////////////////////////////////////////////////////////
                                   
                               }
                               else{
                                echo "Erorr";
                               }
                            }
                        }
                    ?>
                    <form class="form-horizontal form-material" action="" method="POST" novalidate
                        enctype="multipart/form-data">
                        <h3 class="box-title m-b-20 p-b-10">
                            <center>Reset Password</center>
                        </h3>
                        <?php
                        if(isset($_GET['massage'])){
                        if ($_GET['massage']== 'true')
                        {
                            echo'  <h3 class="box-title m-b-20 p-b-10">
                            <p style="color:green;center;">Email send successfully</p>
                        </h3>';
                        }
                        else{
                            echo'  <h3 class="box-title m-b-20 p-b-10">
                            <center>Link use be for </center>
                        </h3>';
                        }
                    
                    }?>
                        <div class="form-group row">
                            <div class="col-lg-12 col-xs-18">
                                <div class="controls">
                                    <div class="input-group">
                                        <input type="email" name="Email" class="form-control username"
                                            placeholder="Staff Email" required
                                            data-validation-required-message="Please enter Staff Email">
                                    </div>
                                    <!--end input-group-->
                                </div>
                                <!--end controls-->
                            </div>
                            <!--end col-sm-9-->
                        </div>
                        <!--end form-group row --->


                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                    name="submitLogin" type="submit"><i class="fa fa-key"></i>Send Email</button>
                            </div>
                        </div>


                    </form>
                    <!--end form application leave form-->


                    <div class="row">
                        <div class="col-lg-12 col-md-12 sub-footer">
                            <p class="text-muted">
                                <small>
                                    Copyright 2020. All Rights Reserved by <a class="text-blue-dark" href="#"><br>
                                        Nizwa College of Technology<br>
                                        E-Service Development Team</a>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end login card-->
        </div>
        <!--end login register-->
    </section>
    <?php include('include_scripts.php'); ?>
    <script>
    $(document).ready(function() {
        $('.username').focus();
    });
    </script>
</body>

</html>