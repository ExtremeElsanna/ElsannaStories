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
	
	
	
	
	if (isset($_GET['code'])) {
		// Connect to DB
		if(!isset($pdo)) {
			$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
		}
		
		date_default_timezone_set('UTC');
		$dropOff = strtotime(date("Y-m-d H:i:s")) - 86400;
		
		$stmt = $pdo->prepare('DELETE FROM PasswordReset WHERE DateCreated < :dropOff;');
		$stmt->bindParam(':dropOff', $dropOff, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		
		// Get users with given reset code
		$stmt = $pdo->prepare('SELECT PasswordResetId,UserId FROM PasswordReset WHERE PasswordResetCode = :code;');
		$stmt->bindParam(':code', $_GET['code'], PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		$passwordResetId = $row['PasswordResetId'];
		$userId = $row['UserId'];
		
		
		// Check the user exists
		if($userId != "") {
			$stmt = $pdo->prepare('SELECT Id,Username,Email FROM Users WHERE Id = :userId;');
			$stmt->bindParam(':userId', $userId, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$row = $stmt->fetch();
			// Save important information
			$userId = $row['Id'];
			$username = $row['Username'];
			$email = $row['Email'];
			
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
			
			// Delete the reset code
			$stmt = $pdo->prepare('DELETE FROM PasswordReset WHERE PasswordResetId = :id;');
			$stmt->bindParam(':id', $passwordResetId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			
			// Send new password to email
			$subject = "CONFIDENTIAL - www.elsannastories.com New Password";
			$body = str_replace("UNIQUEUSER",$username,str_replace("UNIQUEPASS",$newPassword,file_get_contents('PasswordEmail.html')));
			sendEmail($config,$subject,$email,$username,$body);
			
			header("Location: /login/?code=12");
			die();
		} else {
			// No reset entry under that code
			header("Location: /?code=2");
			die();
		}
	} else {
		// No code supplied
		header("Location: /?code=2");
		die();
	}
?>