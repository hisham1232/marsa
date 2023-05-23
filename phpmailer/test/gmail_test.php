<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/

define('GUSER', 'email_add_na_gmail@gmail.com'); // GMail username
define('GPWD', 'password_dito'); // GMail password

require '../class.phpmailer.php';

function smtpmailer($to, $from, $from_name, $subject, $body) { 
    global $error;
    $mail = new PHPMailer();  // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465; 
    $mail->Username = GUSER;  
    $mail->Password = GPWD;           
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //$mail->AddAddress($to);    
    
    if (is_array($to)){
        foreach($to as $k =>$v){
            $mail->AddAddress($v);    
        }
    }else{
        $mail->AddAddress($to); 
    }
    
    if(!$mail->Send()) {
        $error = 'Mail error: '.$mail->ErrorInfo; 
        return false;
    } else {
        $error = 'Message sent!';
        return true;
    }
}

$emailAddressSentTo = "tothisemail@yahoo.com";
$emailMsg['body'] .= "test body";
$emailMsg['subject'] = "test subject";

if (smtpmailer($emailAddressSentTo, 'Sender@yahoo.com', 'sender name', $emailMsg['subject'], $emailMsg['body'])) {
                        //echo "Message Sent to GMAIL.";
                    }

        



/*
try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$body             = file_get_contents('contents.html');
	$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 25;                    // set the SMTP server port
	$mail->Host       = "mail.yourdomain.com"; // SMTP server
	$mail->Username   = "name@domain.com";     // SMTP server username
	$mail->Password   = "password";            // SMTP server password

	$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("name@domain.com","First Last");

	$mail->From       = "name@domain.com";
	$mail->FromName   = "First Last";

	$to = "someone@example...com";

	$mail->AddAddress($to);

	$mail->Subject  = "First PHPMailer Message";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);

	$mail->IsHTML(true); // send as HTML

	$mail->Send();
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
*/
?>