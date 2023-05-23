<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        if($allowed){
            $testEmail = new sendMail;
            $one = "rolen.yabut@nct.edu.om";
            $two = "rolenblueblade29@gmail.com";
            $three = "iam.raizen26@gmail.com";
            $to = array();
            array_push($to,$one,$two,$three);
            $from_name = 'hrms@nct.edu.om';
            $from = 'HRMS - 3.0';
            $subject = 'NCT-HRMD ACCOUNT CREATION FOR NEW STAFF';
            $d = '-';
            $message = '<html><body>';
            $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hrdlogo_small.png" width="419" height="65" />';
            $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>Task Request Number:</strong> </td><td>".$d."</td></tr>";
            $message .= "<tr style='background:#EFFBFB'><td><strong>Date Started:</strong> </td><td>".$d."</td></tr>";
            $message .= "<tr style='background:#E0F8F7'><td><strong>Task Status:</strong> </td><td>Started</td></tr>";
            $message .= "<tr style='background:#EFFBFB'><td><strong>Current Task Service:</strong> </td><td>For Assigning Section</td></tr>";
            $message .= "<tr style='background:#E0F8F7'><td><strong>Staff Id:</strong> </td><td>".$d."</td></tr>";
            $message .= "<tr style='background:#EFFBFB'><td><strong>Staff Name:</strong> </td><td>".$d."</td></tr>";
            $message .= "<tr style='background:#E0F8F7'><td><strong>Staff Department:</strong> </td><td>".$d."</td></tr>";
            $message .= "<tr style='background:#EFFBFB'><td><strong>Joining Date:</strong> </td><td>".date('d/m/Y',time())."</td></tr>";
            $message .= "<tr style='background:#E0F8F7'><td><strong>Mobile Number:</strong> </td><td>".$d."</td></tr>";
            $message .= "</table>";
            $message .= "<hr/>";
            $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION HISTORIES</h3>";
            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
            $message .= "<tr style='background:#F8E0E0'>";
                $message .= "<th><strong>Staff Name</strong></th>";
                $message .= "<th><strong>Date/Time</strong></th>";
                $message .= "<th><strong>Task List</strong></th>";
                $message .= "<th><strong>Notes/Comments</strong></th>";
                $message .= "<th><strong>Status</strong></th>";
            $message .= "</tr>";
            $ctr = 1; $stripeColor = "";	
            //foreach($loadTaskProcessHistory->data as $row){
            for($i=1; $i<=3; $i++){    
                if($ctr % 2 == 0) {
                    $stripeColor = '#FBEFEF';
                } else {
                    $stripeColor = '#FBF2EF';
                }
                $fullStaffNameEmail = "Staff Name Here";
                $dateNotesEmail = date('d/m/Y H:i:s',time());
                $taskListEmail = "Task List Name Here";
                $notesEmail = "Comment Here";
                $statusEmail = "Status Here";
                $message .= "
                    <tr style='background:$stripeColor'>
                        <td style='width:200px'>".$fullStaffNameEmail.$i."</td>
                        <td style='width:200px'>".$dateNotesEmail.$i."</td>
                        <td style='width:200px'>".$taskListEmail.$i."</td>
                        <td style='width:200px'>".$notesEmail.$i."</td>
                        <td style='width:200px'>".$statusEmail.$i."</td>
                </tr>";
                $ctr++;
            }
            $message .= "</table>";
            $message .= "<br/>";
            $message .= "</body></html>";
            $testEmail->smtpMailer($to,$from_name,$from,$subject,$message);

        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>