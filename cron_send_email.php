<?php
require __DIR__."\\classes\\DbaseManipulation.php";
require __DIR__ .'\\phpmailer\\class.phpmailer.php';
$nowDate = date("Y-m-d H:i:s",time());
$mailTask = new DbaseManipulation;
$row = $mailTask->singleReadFullQry("SELECT TOP 1 * FROM system_emails WHERE sentStatus != 'Sent' ORDER BY id desc");
echo $row['recipients'];
exit();
$to = array();

$to = explode(',', $row['recipients']);
if($mailTask->totalCount != 0) {
	$sendEmail = new sendMail;
    if($sendEmail->smtpMailer($to,$row['fromName'],$row['comesFrom'],$row['subject'],$row['message'])) {
        $fields = [
            'sentStatus'=>'Sent',
            'dateSent'=>$nowDate
        ];
        $mailTask->update("system_emails",$fields,$row['id']);
        echo "Email Sent...";
    }  else {
        echo "Email Sending, Failed...";
    }  
} else {
    echo "No Pending Email Found To Send...";
}
?>
