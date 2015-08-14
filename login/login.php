<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if (!isset($_POST['refer'])) {
		$_POST['refer'] = "/";
	}
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	
	$upperUser = mb_strtoupper($_POST['user'], 'UTF-8');
	
	# Usertype Guide
	# 1		User
	# 2		Developer
	# 4		Moderator
	# 8		Database
	# 16	Admin
	
	$stmt = $pdo->prepare('SELECT Id,Username,Hash,Salt,Activated FROM Users WHERE UpperUser = :upperUser');
	$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	$userId = $row['Id'];
	$user = $row['Username'];
	$hash = $row['Hash'];
	$salt = $row['Salt'];
	$activated = $row['Activated'];
	if ($userId != "") {
		# Correct username
		if ($activated == 1) {
			# Account activated
			$options = [
					'cost' => $config['PsaltCost'],
					'salt' => $salt.$config['Ppepper'],
				];
			$newHash = password_hash($_POST['password'], $config['PhashPattern'], $options);
			
			if ($newHash == $hash) {
				# Password correct
				$_SESSION['loggedIn'] = 1;
				$_SESSION['userId'] = $userId;
				$_SESSION['username'] = $user;
				header("Location: ".$_POST['refer']);
				die();
			} else {
				# Password wrong
				header("Location: /login/?refer=".$_POST['refer']);
				die();
			}
		} else {
			# Account not activated
			header("Location: /login/?refer=".$_POST['refer']);
			die();
		}
	} else {
		# Wrong username
		header("Location: /login/?refer=".$_POST['refer']);
		die();
	}
?>