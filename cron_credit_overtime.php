<?php
require __DIR__."\\classes\\DbaseManipulation.php";
            $to = array();
            $error_count = 0;
            $helper = new DbaseManipulation;
            $info = new DbaseManipulation;
            $info2 = new DbaseManipulation;
            $logs = new DbaseManipulation;
            $save = new DbaseManipulation;
            $drafts = $helper->readData("SELECT * FROM internalleaveovertimedetails_draft WHERE status = 'Approved'");
            if($helper->totalCount != 0) {
                foreach($drafts as $draft){
                    $id = $draft['id'];
                    $staffId = $draft['staffId'];
                    $startDate = $draft['startDate'];
                    $endDate = $draft['endDate'];
                    $internalleaveovertime_id = $draft['internalleaveovertime_id'];
                    $notes = $draft['notes'];
                    $total = $draft['total'];
                    $summation = 0;
                    $rows = $logs->readData("SELECT * FROM fpuserlog WHERE userid = '$staffId' AND recordDate >= '$startDate' AND recordDate <= '$endDate' AND (inEvent = 'IN' OR outEvent = 'OUT') ORDER BY recordDate ASC");
                    if($logs->totalCount != 0) {
                        foreach($rows as $row) {
                            $summation++;
                        }
                    }
                    //die("-->".$summation);
                    if($summation > 0) {
                        $fields = [
                            'internalleavebalance_id'=>$internalleaveovertime_id,
                            'leavetype_id'=>0,
                            'staffId'=>$staffId,
                            'startDate'=>$startDate,
                            'endDate'=>$endDate,
                            'total'=>$summation,
                            'status'=>'Saved',
                            'notes'=>$notes,
                            'addType'=>1,
                            'createdBy'=>'413047'
                        ];
                        if($save->insert("internalleavebalancedetails",$fields)){
                            echo "Leaves Credit Added.<br/>";
                            if($total == $summation) { //Will only mark Credited if total days counted in fpuserlog table is the same as the total days in draft
                                $sql_update = "UPDATE internalleaveovertimedetails_draft SET status = 'Credited' WHERE id = '$id'";
                                $save->executeSQL($sql_update);     
                            }
                            $error_count = 0;
                        }
                        //$error_count = 0;
                    } else {
                        $error_count = 1;
                    }
                    if($error_count == 0) {
                        //Get the email address of the staff involved
                        $email_address = $info->getContactInfo(2,$staffId,'data');
                        if(!in_array($email_address, $to)){
                            array_push($to,$email_address);
                        } 
                        //Email of the one who filed
                        $created = $info->singleReadFullQry("SELECT createdBy FROM internalleaveovertimefiled WHERE requestNo = '$internalleaveovertime_id'");
                        $created_by = $created['createdBy'];
                        $email_address_created_by = $info->getContactInfo(2,$created_by,'data');   
                        if(!in_array($email_address_created_by, $to)){
                            array_push($to,$email_address_created_by);
                        }
                        //Email of the HR HoD or whoever wants to be informed...
                        $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                        if($info2->totalCount != 0) {
                            foreach($finals as $final){
                                $staff_id = $final['staff_id'];
                                $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                if(!in_array($email_address_finals, $to)){
                                    array_push($to,$email_address_finals);
                                }
                            }
                        }
                      //  goto heaven;
                    } else {
                      //  goto hell;
                    }   
                }
                //echo $error_count;
                // heaven:
                //     $recipients = implode(', ', $to);
                //     //Compose Email and save it to system_email.
                //     $from_name = 'hrms@nct.edu.om';
                //     $from = 'HRMS - 3.0';
                //     $subject = 'NCT-HRMD INTERNAL LEAVE BALANCE CREDITED (OVERTIME)';
                //     $d = '-';
                //     $message = '<html><body>';
                //     $message .= '<img src="http://apps1.nct.edu.om:4443/hrmd3/hr-logo-email.png" width="419" height="65" />';
                //     $message .= "<h3>NCT-HRMS 3.0</h3>";
                //     $message .= '<p>An internal leave balance from your overtime with <strong>REQUEST ID: '.$internalleaveovertime_id.'</strong> has been added and credited into your HR account. Kindly login to HR System for more details.</p>
                //                 <p>For more information please contact the HR Department.</p>';
                //     $message .= "</body></html>";
                //     $transactionDate = date('Y-m-d H:i:s',time());

                //     //Save Email Information in the system_emails table...
                //     $recipients = implode(', ', $to);
                //     $emailFields = [
                //         'requestNo'=>$internalleaveovertime_id,
                //         'moduleName'=>'Overtime - Adding Internal Leave Balance',
                //         'sentStatus'=>'Pending',
                //         'recipients'=>$recipients,
                //         'fromName'=>$from_name,
                //         'comesFrom'=>$from,
                //         'subject'=>$subject,
                //         'message'=>$message,
                //         'createdBy'=>'413047',
                //         'dateEntered'=>$transactionDate,
                //         'dateSent'=>$transactionDate
                //     ];
                //     $saveEmail = new DbaseManipulation;
                //     $saveEmail->insert("system_emails",$emailFields);
				// 	echo "done";
                // hell:
                //     //echo "Adding credits NOT SUCCESSFUL. Please check the fpuserlog table.";
                //     echo "...";                    
            }
    echo "finish";