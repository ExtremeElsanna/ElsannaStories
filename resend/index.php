<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	if (!isset($_GET['id']) and !is_numeric($_GET['id'])) {
		header("Location: /login/?code=7");
		die();
	}
	
	function sendEmail($config,$subject,$address,$name,$body) {
		// Implement PHPMailer class so we can send email
		require_once('/hdd/elsanna-ssl/PHPMailer/PHPMailerAutoload.php');
		
		// Created the mail object
		$mail             = new PHPMailer();

		$body             = stripslashes($body);
		
		// Setup some details
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
	
		// Send email and check for errors
		if(!$mail->Send()) {
		  die( "Mailer Error: " . $mail->ErrorInfo);
		}
	}
	
	// Connect to DB
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	$userId = $_GET['Id'];
	
	// Get all data about this story
	echo $userId;
	die;
	$stmt = $pdo->prepare('SELECT Username FROM Users WHERE Id = :id;');
	$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['Username'] != "") {
		$username = $row['Username'];
		$stmt = $pdo->prepare('SELECT ActivationCode FROM AccountActivation WHERE UserId = :userId;');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		if ($row['ActivationCode'] != "") {
			$code = $row['ActivationCode'];
			$subject = "www.elsannastories.com: ".$username." Account Activation";
			$body = str_replace("UNIQUEUSER",$username,str_replace("UNIQUELINK","https://www.elsannastories.com/activate/?code=".$code,file_get_contents('RegistrationEmail.html')));
			sendEmail($config,$subject,$config['EtestAddress'],$username,$body);
			header("Location: /login/?code=6");
			die();
		} else {
			header("Location: /login/?code=9");
			die();
		}
	} else {
		header("Location: /login/?code=8");
		die();
	}
?>