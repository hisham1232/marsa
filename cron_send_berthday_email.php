<?php

ini_set("display_errors", 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require __DIR__."\\classes\\DbaseManipulation.php";
//require __DIR__ .'\\phpmailer\\class.phpmailer.php';
echo "Hellow..."; 

$nowDate = date("Y-m-d H:i:s",time()); 
/*$mailTask = new DbaseManipulation;
$row = $mailTask->singleReadFullQry("SELECT TOP 1 * FROM staff WHERE birthdate = $nowDate ORDER BY id");
$to = array();
$to = explode(',', $row['recipients']);
print_r($to);
echo "Hellow...$to";
//if($mailTask->totalCount != 0) {
    
    $msg="<html>
    <body bgcolor='#EBDEF0'>
    <center>
    <img src='http://apps1.nct.edu.om:4443/hrmd3/images/birthdaywish.jpg' width='80%' />
    </center></body></html>";
	$sendEmail = new sendMail;
   if($sendEmail->smtpMailer('khamis.alkhusaibi@gmail.com','hrms@nct.edu.om','HRMS - 3.0','happy birthday',$row['message'])) {
        $fields = [
            'sentStatus'=>'Sent',
            'dateSent'=>$nowDate
        ];
        $mailTask->update("system_emails",$fields,$row['id']);
        echo "Email Sent...";
    }  else {
        echo "Email Sending, Failed...";
    }*/  /* 
} else {
    echo "No Pending Email Found To Send...";
}*/
$transactionDate = date('Y-m-d H:i:s',time());
$month = date('m');
$day =date('d');
//$to="khamis.alkhusaibi@gmail.com";
//Compose Email and save it to system_email.
$from_name = 'hrms@nct.edu.om';
$from = 'UTAS Nizwa - HRMS';
$subject = 'happy birthday - '.$transactionDate;
$d = '-';
$message = '<html><body bgcolor="#EBDEF0"><center>';
$message .= '<img src="https://apps1.nct.edu.om:4443/hrmd3/images/birthdaywish.jpg" width="100%" />';
$message .= "</center></body></html>";
echo $message;
echo $month;
echo $day;


//Save Email Information in the system_emails table...

    $getIdInfo = new DbaseManipulation;
   
    $Emailquery="SELECT staffId,birthdate,contactdetails.data as StaffEmails
    FROM dbhr3.dbo.staff
    inner join employmentdetail on employmentdetail.staff_id = staff.staffId
    inner join contactdetails on contactdetails.staff_id = staff.staffId
    where employmentdetail.isCurrent=1 and employmentdetail.status_id = 1
          and contactdetails.isCurrent = 'Y' and isFamily = 'N' and contactdetails.contacttype_id = 2 
          and MONTH(staff.birthdate) = $month AND DAY(staff.birthdate) = ".$day;

          //echo $Emailquery;
    $to = array();
   
    $staffEmails = $getIdInfo->readData($Emailquery);
	echo "";
    if($getIdInfo->totalCount != 0) {
		
        foreach ($staffEmails as $row) {
     
		array_push($to,$row['StaffEmails']);
        
    }
		
  
    array_push($to,'hr@nct.edu.om','khamis.alkhusaibi@nct.edu.om');
   // array_push($to,'khamis.alkhusaibi@nct.edu.om');
    $emailRecipient = new sendMail;
    if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)){
        //Save Email Information in the system_emails table...    
        $from_name = $from_name;
        $from = $from;
        $subject = $subject;
        $message = $message;
        $transactionDate = date('Y-m-d H:i:s',time());
        $to = $to;
        $recipients = implode(', ', $to);
        $emailFields = [
            'requestNo'=>'BD',
            'moduleName'=>'-',
            'sentStatus'=>'Sent',
            'recipients'=>$recipients,
            'fromName'=>$from_name,
            'comesFrom'=>$from,
            'subject'=>$subject,
            'message'=>$message,
            'createdBy'=>'107034',
            'dateEntered'=>$transactionDate,
            'dateSent'=>$transactionDate
        ];
        //echo $save->displayArr($emailFields);
        $saveEmail = new DbaseManipulation;
        $saveEmail->insert("system_emails",$emailFields);  
        ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <p>Email processed successfully.</p>

</div>
<?php
        exit();
    } else {
        //Save Email Information in the system_emails table...    
        $from_name = $from_name;
        $from = $from;
        $subject = $subject;
        $message = $message;
        $transactionDate = date('Y-m-d H:i:s',time());
        $to = $to;
        $recipients = implode(', ', $to);
        $emailFields = [
            'requestNo'=>'BD',
            'moduleName'=>'-',
            'sentStatus'=>'Failed',
            'recipients'=>$recipients,
            'fromName'=>$from_name,
            'comesFrom'=>$from,
            'subject'=>$subject,
            'message'=>$message,
            'createdBy'=>'107034',
            'dateEntered'=>$transactionDate,
            'dateSent'=>$transactionDate
        ];
        //echo $save->displayArr($emailFields);
        $saveEmail = new DbaseManipulation;
        $saveEmail->insert("system_emails",$emailFields);
        exit();
    }
}
else{
    echo "No Data";
    exit();
}
     
?>