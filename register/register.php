<?php
	function generateUser($config,$pdo) {		
		$salt = mcrypt_create_iv($config['PsaltLength'], $config['PsaltPattern']);
		$options = [
			'cost' => $config['PsaltCost'],
			'salt' => $salt,
		];
		$hash = password_hash($_POST['password'], $config['PhashPattern'], $options);
		
		$user = $_POST['user'];
		$userUpper = mb_strtoupper($_POST['user'], 'UTF-8');
		$email = mb_strtoupper($_POST['email'], 'UTF-8');
		date_default_timezone_set('UTC');
		$joinDate = date("Y-m-d");
		
		$stmt = $pdo->prepare('INSERT INTO Users (Username, UpperUser, Hash, Salt, Email, DateJoined) VALUES (:user,:upperuser,:hash,:salt,:email,:joindate);');
		$stmt->bindParam(':user', $user, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':upperuser', $userUpper, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':hash', $hash, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':salt', $salt, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':email', $email, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':joindate', $joinDate, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		
		$stmt = $pdo->prepare('SELECT Id FROM Users WHERE Username = :user');
		$stmt->bindParam(':user', $user, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		$userId = $row['Id'];
		echo "Inserting Account = ID : ".$userId." | User : ".$user." | Hash : ".$hash." | Salt : ".$salt." | Email : ".$email." | Join Date : ".$joinDate."<br>";
		return $userId;
		
	}
	
	function generateActivation($pdo, $userId, $length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, strlen($characters) - 1)];
		}
		$stmt = $pdo->prepare('INSERT INTO AccountActivation (UserId, ActivationCode) VALUES (:userId, :activationCode);');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':activationCode', $code, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		//$stmt->execute();
		echo "Inserting Activation Code = UserID : ".$userId." | Code : ".$code."<br>";
		return $code;
	}
	
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
	
		echo "Email sent<br>";
		//if(!$mail->Send()) {
		//  die( "Mailer Error: " . $mail->ErrorInfo);
		//}
	}
	
	include("/hdd/config/config.php");
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword']);
	$stmt = $pdo->prepare("SET NAMES 'utf8'");
	$stmt->execute();
	
	$userId = generateUser($config,$pdo);
	$code = generateActivation($pdo, $userId,20);
	sendEmail($config,"Test Email",$config['EtestAddress'],"Forename Surname","Body of email");
	//"www.elsannastories.com: ".$_POST['user']." Account Activation";
	//$_POST['fname']." ".$_POST['sname']
?>