<?php
	function generateCode($length) {
		// Create $length character long code
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $code;
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
	
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if (!isset($_POST['refer'])) {
		$_POST['refer'] = "/";
	}
	if (!isset($_POST['email'])) {
		// Email not set
		header("Location: /reset/?refer=".$_POST['refer']."&code=1");
		die();
	} else {
	}
	// Connect to DB
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	
	$upperEmail = mb_strtoupper($_POST['email'], 'UTF-8');
	
	// Usertype Guide
	// 1		User
	// 2		Developer
	// 4		Moderator
	// 8		Database
	// 16		Admin
	
	// Get important details about user
	$stmt = $pdo->prepare('SELECT Id,Username,Email FROM Users WHERE Email = :upperEmail;');
	$stmt->bindParam(':upperEmail', $upperEmail, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	// Save important information
	$userId = $row['Id'];
	$username = $row['Username'];
	$email = $row['Email'];
	if ($userId != "") {
		// User Exists
		// Generate new Pass
		$newPassword = generateCode(10);
		// Generate Salt
		$newSalt = generateCode($config['PsaltLength']);
		$options = [
			'cost' => $config['PsaltCost'],
			'salt' => $newSalt.$config['Ppepper'],
		];
		// Create password hash
		$newHash = password_hash($newPassword, $config['PhashPattern'], $options);
		// Update user account
		$stmt = $pdo->prepare("UPDATE Users SET Hash = :newHash WHERE Id = :userId;");
		$stmt->bindParam(':newHash', $newHash, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		
		$stmt = $pdo->prepare("UPDATE Users SET Salt = :newSalt WHERE Id = :userId;");
		$stmt->bindParam(':newSalt', $newSalt, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		
		$newChange = 1;
		$stmt = $pdo->prepare("UPDATE Users SET ChangePass = :newChange WHERE Id = :userId;");
		$stmt->bindParam(':newChange', $newChange, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		
		// Send new password to email
		$subject = "CONFIDENTIAL - www.elsannastories.com Password Reset";
		$body = str_replace("UNIQUEUSER",$username,str_replace("UNIQUEPASS",$newPassword,file_get_contents('ResetEmail.html')));
		sendEmail($config,$subject,$config['EtestAddress'],$username,$body);
		
		header("Location: /login/?refer=".$_POST['refer']."&code=10");
		die();
	} else {
		// No User with that email
		header("Location: /reset/?refer=".$_POST['refer']."&code=2");
		die();
	}
?>