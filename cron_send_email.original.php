<?php include  __DIR__ .'\\include_headers.php'; ?>
<!-- Put this script to be called by cron in the server. Specify the time on when this script will be called, prefer frequency is every 5 minutes... -->
<body>
    <div>
        <?php
            $nowDate = date("Y-m-d H:i:s",time());
            $mailTask = new DbaseManipulation;
            $row = $mailTask->singleReadFullQry("SELECT TOP 1 * FROM system_emails WHERE sentStatus != 'Sent' ORDER BY id");
            $to = array();
            $to = explode(',', $row['recipients']);
            //print_r($to); exit;
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
    </div>
    <?php include  __DIR__ .'\\include_scripts.php'; ?>
</body>
</html>