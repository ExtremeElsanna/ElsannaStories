<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if (!isset($_POST['refer'])) {
		$_POST['refer'] = "/";
	}
	// Connect to DB
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	
	$upperUser = mb_strtoupper($_POST['user'], 'UTF-8');
	
	// Usertype Guide
	// 1		User
	// 2		Developer
	// 4		Moderator
	// 8		Database
	// 16	Admin
	
	// Get important details about user
	$stmt = $pdo->prepare('SELECT Id,Username,Hash,Salt,Activated FROM Users WHERE UpperUser = :upperUser;');
	$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	// Save important information
	$userId = $row['Id'];
	$user = $row['Username'];
	$hash = $row['Hash'];
	$salt = $row['Salt'];
	$activated = $row['Activated'];
	if ($userId != "") {
		// Correct username
		if ($activated == 1) {
			// Account activated
			$options = [
					'cost' => $config['PsaltCost'],
					'salt' => $salt.$config['Ppepper'],
				];
			$newHash = password_hash($_POST['password'], $config['PhashPattern'], $options);
			
			if ($newHash == $hash) {
				// Password correct
				$_SESSION['loggedIn'] = 1;
				$_SESSION['userId'] = $userId;
				$_SESSION['username'] = $user;
				date_default_timezone_set('UTC');
				$_SESSION['lastActive'] = time();
				header("Location: ".$_POST['refer']);
				die();
			} else {
				// Password wrong
				header("Location: /login/?refer=".$_POST['refer']."&code=3");
				die();
			}
		} else {
			// Account not activated
			header("Location: /login/?refer=".$_POST['refer']."&code=4");
			die();
		}
	} else {
		// Wrong username
		header("Location: /login/?refer=".$_POST['refer']."&code=5");
		die();
	}
?>