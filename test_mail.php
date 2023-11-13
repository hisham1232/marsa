<?php

include('include_headers_login.php');  

$from_name = 'hrms@nct.edu.om';
$from = 'HRMS - 3.0';
$subject = 'NCT-HRMD STAFF Reset Password  ';
$message = '<html><body>';
$message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
$message .= "<h3>This email for reset HR system Password </h3>";
$message .= "<h3><a href='http://hr.nct.edu.om/hrmd3/newPassword.php?token=$token'> Clik the link for reset password </a></h3>";
$message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
$message .= "<h3>This email for reset HR system Password </h3>";
$message .= "<h3><a href='http://hr.nct.edu.om/hrmd3/newPassword.php?token=$token'> Clik the link for reset password </a></h3>";$message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
$message .= "<h3>This email for reset HR system Password </h3>";
$message .= "<h3><a href='http://hr.nct.edu.om/hrmd3/newPassword.php?token=$token'> Clik the link for reset password </a></h3>";$message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
$message .= "<h3>This email for reset HR system Password </h3>";
$message .= "<h3><a href='http://hr.nct.edu.om/hrmd3/newPassword.php?token=$token'> Clik the link for reset password </a></h3>";$message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
$message .= "<h3>This email for reset HR system Password </h3>";
$message .= "<h3><a href='http://hr.nct.edu.om/hrmd3/newPassword.php?token=$token'> Clik the link for reset password </a></h3>";$message .= "<h3>NCT-HRMS 3.0 STAFF Reset Password</h3>";
$message .= "<h3>This email for reset HR system Password </h3>";
$message .= "<h3><a href='http://hr.nct.edu.om/hrmd3/newPassword.php?token=$token'> Clik the link for reset password </a></h3>";
$message .= "</body></html>";
$to = array();
 array_push($to,'mohammed.ambusaidi@nct.edu.om');
$emailParticipants = new sendMail;
$a=1;
if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
echo "Send";

}
else 
{
    echo"Not Send";
}

    ?>