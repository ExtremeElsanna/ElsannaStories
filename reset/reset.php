<?php
	function generateCode($length) {
		// Create $length character long code
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $code;
	}
	
	function sendEmail($config,$subject,$address,$name,$body) {
		// Implement PHPMailer class so we can send email
		require_once('../PHPMailer/PHPMailerAutoload.php');
		
		// Created the mail object
		$mail             = new PHPMailer();

		$body             = stripslashes($body);
		
		// Setup some details
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 0;                      // enables SMTP debug information (for testing)
													// 1 = errors and messages
													// 2 = messages only
		$mail->SMTPAuth   = true;                   // enable SMTP authentication
		$mail->SMTPSecure = "tls";                  // sets the prefix to the server
		$mail->SMTPOptions = $config['EsmtpOptions'];
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
	
	include("../scripts/sessionHandler.php");
	include("../config.php");
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
	if(!isset($pdo)) {
		try {
			$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die;
		}
	}

	
	$upperEmail = mb_strtoupper($_POST['email'], 'UTF-8');
	
	// Get important details about user
	$stmt = $pdo->prepare('SELECT UserId,Username,Email FROM Users WHERE Email = :upperEmail;');
	$stmt->bindParam(':upperEmail', $upperEmail, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	// Save important information
	$userId = $row['UserId'];
	$username = $row['Username'];
	$email = $row['Email'];
	if ($userId != "") {
		// User Exists
		
		// Create an activation code 20 characters long
		$code = generateCode(20);
		
		date_default_timezone_set('UTC');
		$timestamp = time();
		
		// Create the activation code listing using $userId
		$stmt = $pdo->prepare('INSERT INTO PasswordReset (UserId, PasswordResetCode,TimeCreated) VALUES (:userId, :passwordResetCode, :timeCreated);');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':passwordResetCode', $code, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':timeCreated', $timestamp, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		
		// Send new password link to email
		$subject = "www.elsannastories.com Password Reset";
		$body = str_replace("UNIQUEUSER",$username,str_replace("UNIQUELINK","https://www.elsannastories.com/passwordreset/?code=".$code,file_get_contents('ResetEmail.html')));
		sendEmail($config,$subject,$email,$username,$body);
		
		header("Location: /login/?refer=".$_POST['refer']."&code=9");
		die();
	} else {
		// No User with that email
		header("Location: /reset/?refer=".$_POST['refer']."&code=2");
		die();
	}
?>
