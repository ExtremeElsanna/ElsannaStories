<?php
	include("/hdd/database-config/config.php");
	
	function sendEmail($subject,$address,$name,$body) {
		require_once('/hdd/elsanna-ssl/PHPMailer/PHPMailerAutoload.php');

		$mail             = new PHPMailer();

		$body             = stripslashes($body);

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 0;                      // enables SMTP debug information (for testing)
													// 1 = errors and messages
													// 2 = messages only
		$mail->SMTPAuth   = true;                   // enable SMTP authentication
		$mail->SMTPSecure = "";                  // sets the prefix to the server
		$mail->Host       = $Ehost;        // sets hotmail as the SMTP server
		$mail->Port       = $EsmtpPort;                    // set the SMTP port for the hotmail server
		$mail->Username   = "no-reply@".$Edomain;      // hotmail username
		$mail->Password   = $EnoReplyPass;           // hotmail password
		$mail->SetFrom('no-reply@'.$Edomain, 'No-Reply');
		$mail->AddReplyTo('no-reply@'.$Edomain,'No-Reply');
		$mail->Subject    = $subject;
		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);

		$mail->AddAddress($address, $name);

		if(!$mail->Send()) {
		  die( "Mailer Error: " . $mail->ErrorInfo);
		}
	}
	
	sendEmail("Test Email",$EtestAddress,"Forename Surname","Body of email");
	//"www.elsannastories.com: ".$_POST['user']." Account Activation";
	//$_POST['fname']." ".$_POST['sname']
?>