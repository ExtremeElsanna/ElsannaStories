<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	
	$upperUser = mb_strtoupper($_POST['user'], 'UTF-8');
	
	$stmt = $pdo->prepare('SELECT Id,User,Hash,Salt,Activated FROM Users WHERE UpperUser = :upperUser');
	$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	$userId = $row['Id'];
	$user = $row['User'];
	$hash = $row['Hash'];
	$salt = $row['Salt'];
	$activated = $row['Activated'];
	if ($userId != "") {
		if ($activated == 1) {
			$options = [
					'cost' => $config['PsaltCost'],
					'salt' => $salt.$config['Ppepper'],
				];
			$newHash = password_hash($_POST['password'], $config['PhashPattern'], $options);
			
			if ($newHash == $hash) {		
				$_SESSION['loggedIn'] = 1;
				$_SESSION['userId'] = $userId;
				$_SESSION['username'] = $user;
				header("Location: /");
				die();
			} else {			
				header("Location: /login/");
				die();
			}
		} else {
			header("Location: /login/");
			die();
		}
	} else {
		header("Location: /login/");
		die();
	}
?>