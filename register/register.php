<?php
	
	function sendEmail($config,$subject,$address,$name,$body) {
		require_once('/hdd/elsanna-ssl/PHPMailer/PHPMailerAutoload.php');

		$mail             = new PHPMailer();

		$body             = stripslashes($body);

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 0;                      // enables SMTP debug information (for testing)
													// 1 = errors and messages
													// 2 = messages only
		$mail->SMTPAuth   = true;                   // enable SMTP authentication
		$mail->SMTPSecure = "";                  // sets the prefix to the server
		$mail->Host       = $config['Ehost'];        // sets the SMTP server
		$mail->Port       = $config['EsmtpPort'];                    // set the SMTP port
		$mail->Username   = "no-reply@".$config['Edomain'];      // username
		$mail->Password   = $config['EnoReplyPass'];           // password
		$mail->SetFrom('no-reply@'.$config['Edomain'], 'No-Reply');
		$mail->AddReplyTo('no-reply@'.$config['Edomain'],'No-Reply');
		$mail->Subject    = $subject;
		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);

		$mail->AddAddress($address, $name);

		if(!$mail->Send()) {
		  die( "Mailer Error: " . $mail->ErrorInfo);
		}
	}
	
	include("/hdd/config/config.php");
	sendEmail($config,"Test Email",$config['EtestAddress'],"Forename Surname","Body of email");
	//"www.elsannastories.com: ".$_POST['user']." Account Activation";
	//$_POST['fname']." ".$_POST['sname']
?>