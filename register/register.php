<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	function generateUser($config,$pdo) {		
		$salt = generateCode($config['PsaltLength']);
		$options = [
			'cost' => $config['PsaltCost'],
			'salt' => $salt.$config['Ppepper'],
		];
		$hash = password_hash($_POST['password'], $config['PhashPattern'], $options);
		
		$user = $_POST['user'];
		$upperUser = mb_strtoupper($_POST['user'], 'UTF-8');
		$email = mb_strtoupper($_POST['email'], 'UTF-8');
		date_default_timezone_set('UTC');
		$joinDate = date("Y-m-d");
		
		$stmt = $pdo->prepare('INSERT INTO Users (Username, UpperUser, Hash, Salt, Email, DateJoined) VALUES (:user,:upperuser,:hash,:salt,:email,:joindate);');
		$stmt->bindParam(':user', $user, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':upperuser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
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
		//echo "Inserting Account = ID : ".$userId." | User : ".$user." | Email : ".$email." | Join Date : ".$joinDate."<br>";
		return $userId;
		
	}
	
	function generateCode($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $code;
	}
	
	function generateActivation($pdo, $userId) {
		$code = generateCode(20);
		$stmt = $pdo->prepare('INSERT INTO AccountActivation (UserId, ActivationCode) VALUES (:userId, :activationCode);');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':activationCode', $code, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		//echo "Inserting Activation Code = UserID : ".$userId." | Code : ".$code."<br>";
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
	
		//echo "Email sent:<br>";
		//echo $body."<br>";
		if(!$mail->Send()) {
		  die( "Mailer Error: " . $mail->ErrorInfo);
		}
	}
	
	$captcha = $_POST['g-recaptcha-response'];
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$config['RcaptchaSecretKey']."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
	$googleResponse = json_decode($response, true);
	if ($googleResponse['success'] == 1) {
		# ReCaptcha correct
		if (strlen($_POST['user']) >= 4) {
			# Username >= 4 chars
			if (strlen($_POST['user']) <= 25) {
				# Username <= 25 chars
				if (strlen($_POST['password']) >= 7) {
					# Password >= 7 chars
					if (strlen($_POST['password']) <= 20) {
						# Password <= 20 chars
						if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
							# Email valid
							if ($_POST['user'] != "Guest" and $_POST['user'] != "guest") {
								# Username valid
								if ($_POST['password'] == $_POST['password_confirm']) {
									# Password valid
									if (preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz0123456789].*)+/i",$_POST['user']) == 0) {
										# Username contains valid characters
										if (preg_match("/(?:.*[^abcdefghijklmnopqrstuvwxyz0123456789].*)+/i",$_POST['password']) == 0) {
											# Password contains valid characters
											$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);$stmt = $pdo->prepare('SELECT Id FROM Users WHERE Username = :user');
											
											$upperUser = mb_strtoupper($_POST['user'], 'UTF-8');
											$stmt = $pdo->prepare('SELECT Id FROM Users WHERE UpperUser = :upperUser');
											$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
											$stmt->execute();
											$row = $stmt->fetch();
											if ($row['Id'] == "") {
												$email = mb_strtoupper($_POST['email'], 'UTF-8');
												$stmt = $pdo->prepare('SELECT Id FROM Users WHERE Email = :email');
												$stmt->bindParam(':email', $email, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
												$stmt->execute();
												$row = $stmt->fetch();
												if ($row['Id'] == "") {
													$userId = generateUser($config,$pdo);
													$code = generateActivation($pdo, $userId);
													$subject = "www.elsannastories.com: ".$_POST['user']." Account Activation";
													$body = str_replace("UNIQUEUSER",$_POST['user'],str_replace("UNIQUELINK","https://www.elsannastories.com/activate/?code=".$code,file_get_contents('RegistrationEmail.html')));
													sendEmail($config,$subject,$config['EtestAddress'],$_POST['user'],$body);
													header("Location: /login/");
													die();
												} else {
													# Email already exists
													header("Location: /register/");
													die();
												}
											} else {
												# Username already exists
												header("Location: /register/");
												die();
											}
										} else {
											# Password contains invalid characters
											header("Location: /register/");
											die();
										}
									} else {
										# Username contains invalid characters
										header("Location: /register/");
										die();
									}
								} else {
									# Password is not equal to Confirmation Password
									header("Location: /register/");
									die();
								}
							} else {
								# Username is Guest or guest
								header("Location: /register/");
								die();
							}
						} else {
							# Email not valid
							header("Location: /register/");
							die();
						}
					} else {
						# Password longer than 20 chars
						header("Location: /register/");
						die();
					}
				} else {
					# Password shorter than 7 chars
					header("Location: /register/");
					die();
				}
			} else {
				# Username longer than 25 chars
				header("Location: /register/");
				die();
			}
		} else {
			# Username shorter than 4 chars
			header("Location: /register/");
			die();
		}
	} else {
		# ReCaptcha wrong
		header("Location: /register/");
		die();
	}
?>